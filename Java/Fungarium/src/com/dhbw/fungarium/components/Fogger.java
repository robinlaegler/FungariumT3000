package com.dhbw.fungarium.components;

import org.apache.logging.log4j.LogManager;
import org.apache.logging.log4j.Logger;

public class Fogger extends Actor{
	
	public Fogger() {
		super(GPIO_Channel.Fogger,LogManager.getLogger(Fogger.class));
	}

}
