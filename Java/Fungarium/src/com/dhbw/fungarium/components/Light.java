package com.dhbw.fungarium.components;

import java.util.Calendar;
import java.util.GregorianCalendar;

import org.apache.logging.log4j.LogManager;

public class Light extends Actor{

	public Light() {
		super(GPIO_Channel.Light,LogManager.getLogger(Light.class));
	}

	public void checkLight() {
		// Check if light has to be switched on/off based on the rules.
		Calendar currentDate = new GregorianCalendar();
		Calendar lightOnDate = gct.getRulesData().getLightOnDate();
		Calendar lightOffDate = gct.getRulesData().getLightOffDate();
		if (currentDate.after(lightOnDate) && currentDate.before(lightOffDate)) {
			// Überprüfen ob das licht aus ist
			if (!gct.isLight()) {
				this.on(); // Licht anschalten
				gct.setLight(true);
			}
		}
		else {
			// Überprüfen, ob das Licht an ist
			if (gct.isLight()) {
				this.off(); // Licht anschalten
				gct.setLight(false);
			}

		}
	}
}


