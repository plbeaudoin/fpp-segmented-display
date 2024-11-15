
class FPPSegmentedDisplayPlugin : public FPPPlugins::Plugin {
    int brightness = -1;
    std::string configLocation;

    FPPSegmentedDisplayPlugin() : FPPPlugins::Plugin("fpp-segmented-display") {
        int startBrightness = 100;
        configLocation = FPP_DIR_CONFIG("/plugin.fpp-segmented-display.json");
        if (FileExists(configLocation)) {
            Json::Value root;
            if (LoadJsonFromFile(configLocation, root)) {
                if (root.isMember("brightness")) {
                    startBrightness = root["brightness"].asInt();
                }
            }
        }
        setBrightness(startBrightness);
        registerCommand();
    }

    virtual ~FPPSegmentedDisplayPlugin() {}

    void setBrightness(int i) {
        if (brightness == i) {
          return
        }
          
        brightness = i;
        for (int x = 0; x < 256; x++) {
            float b = x * (float)i;
            b /= 100.0f;
            int newb = std::round(b);
            if (newb == 0 && b > 0.2) {
                newb = 1;
            }
            if (newb > 255) {
                newb = 255;
            }
            map[x] = newb;
        }
        Json::Value val;
        val["brightness"] = i;
        SaveJsonToFile(val, configLocation);
    }
}

extern "C" {
    FPPPlugins::Plugin *createPlugin() {
        return new FPPSegmentedDisplayPlugin();
    }
}