SRCDIR ?= /opt/fpp/src
include ${SRCDIR}/makefiles/common/setup.mk
include $(SRCDIR)/makefiles/platform/*.mk

all: libfpp-segmented-display.$(SHLIB_EXT)
debug: all

OBJECTS_fpp_segmented_display_so += src/FPPSegmentedDisplay.o
LIBS_fpp_segmented_display_so += -L${SRCDIR} -lfpp -ljsoncpp -lhttpserver
CXXFLAGS_src/FPPSegmentedDisplay.o += -I${SRCDIR}

%.o: %.cpp Makefile
	$(CCACHE) $(CC) $(CFLAGS) $(CXXFLAGS) $(CXXFLAGS_$@) -c $< -o $@

libfpp-segmented-display.$(SHLIB_EXT): $(OBJECTS_fpp_segmented_display_so) ${SRCDIR}/libfpp.$(SHLIB_EXT)
	$(CCACHE) $(CC) -shared $(CFLAGS_$@) $(OBJECTS_fpp_segmented_display_so) $(LIBS_fpp_segmented_display_so) $(LDFLAGS) -o $@

clean:
	rm -f libfpp-segmented-display.so $(OBJECTS_fpp_segmented_display_so)