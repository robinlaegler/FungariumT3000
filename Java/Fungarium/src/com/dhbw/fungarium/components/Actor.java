package com.dhbw.fungarium.components;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

import com.dhbw.config.GCT;
import com.pi4j.wiringpi.Gpio;

public class Actor {
	protected Logger lg;
	protected GPIO_Channel ioChannel;
	protected GCT gct;
	
	public Actor(GPIO_Channel ioChannel, Logger lg) {
		super();

		if (lg == null)
			this.lg = LogManager.getLogger(Actor.class);
		else
			this.lg = lg;
		this.ioChannel = ioChannel;
		this.gct = GCT.getInstance();
	}

	public void on() {
		// Setzen des GPIO Pins
		lg.info("Going to switch on actor {}.", ioChannel.getDescription());
		try {
			//Gpio.digitalWrite(ioChannel.getPin(), Gpio.LOW); // Wegen Testzwecke auskommentiert
			lg.info("Actor {} switched on.", ioChannel.getDescription());
		} catch (Throwable t) {
			lg.error("Error while switching on actor {}. Reason: {}", ioChannel.getDescription(), t.getMessage());
		}
	}

	public void off() {
		// Rücksetzen des GPIO Pins
		lg.info("Going to switch off actor {}.", ioChannel.getDescription());
		try {
			//Gpio.digitalWrite(ioChannel.getPin(), Gpio.HIGH); // Wegen Testzwecke auskommentiert
			lg.info("Actor {} switched off.", ioChannel.getDescription());
		} catch (Throwable t) {
			lg.error("Error while switching off actor {}. Reason: {}", ioChannel.getDescription(), t.getMessage());
		}
	}
}
