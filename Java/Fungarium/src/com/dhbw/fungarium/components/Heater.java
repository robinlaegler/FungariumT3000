package com.dhbw.fungarium.components;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

public class Heater extends Actor{
	
	public Heater() {
		super(GPIO_Channel.Heater,LogManager.getLogger(Heater.class));
	}
	
}