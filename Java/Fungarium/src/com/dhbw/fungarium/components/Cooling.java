package com.dhbw.fungarium.components;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

public class Cooling extends Actor{
	
	public Cooling() {
		super(GPIO_Channel.Cooling,LogManager.getLogger(Cooling.class));
	}
}
