package com.dhbw.fungarium.components;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

public class Fan extends Actor{
	
	public Fan() {
		super(GPIO_Channel.Fan,LogManager.getLogger(Fan.class));
	}
}
