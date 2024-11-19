<?php

include_once '/opt/fpp/www/common.php';
$pluginName = "FPP-Segmented-Display";

if (!isset($pluginSettings) || empty($pluginSettings)) {
    $pluginSettings = array();
    $pluginSettingInfos = array();

    LoadPluginSettings($pluginName);
}

if (isset($_POST['upload']) && isset($_FILES['xlightModelFile'])) {
    $fileTmpPath = $_FILES['xlightModelFile']['tmp_name'];
    $fileName = $_FILES['xlightModelFile']['name'];
    $fileSize = $_FILES['xlightModelFile']['size'];
    $fileType = $_FILES['xlightModelFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // Check if the file is a valid Xlight model file (you can add more checks if needed)
    if ($fileExtension == "xmodel") {
        $fileContent = file_get_contents($fileTmpPath);

        // Store the file content in the plugin settings
        $pluginSettings['xlightModelFileContent'] = $fileContent;
        SavePluginSettings($pluginName, $pluginSettings);

        echo "File uploaded and content saved successfully.";
    } else {
        echo "Invalid file type. Please upload a valid Xlight model file.";
    }
}

if (isset($_POST['clear'])) {
    // Clear the xlightModelFileContent setting
    unset($pluginSettings['xlightModelFileContent']);
    SavePluginSettings($pluginName, $pluginSettings);

    echo "Xlight model file content cleared.";
}

// Only display the form if the model is not already set
if (!isset($pluginSettings['xlightModelFileContent'])) {
?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="xlightModelFile">Xlight Model:</label>
        <input type="file" name="xlightModelFile" id="xlightModelFile">
        <input type="submit" name="upload" value="Upload">
    </form>
<?php
} else {
?>
  <form action="" method="post">
    <input type="submit" name="clear" value="Clear">
  </form>
<?php
$xlightModelContent = $pluginSettings['xlightModelFileContent'];
$xml = simplexml_load_string($xlightModelContent);

if ($xml !== false) {
  echo "<table border='1'>";
  echo "<tr><th>State</th><th>Value</th></tr>";
  foreach ($xml->custommodel->stateInfo as $state) {
    echo "<tr>";
    foreach ($state->attributes() as $name => $value) {
      echo "<td>" . htmlspecialchars($name) . "</td><td>" . htmlspecialchars($value) . "</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "No valid states found in the Xlight model file content.";
}
?>
<?php
}
?>
<h1>Settings</h1>