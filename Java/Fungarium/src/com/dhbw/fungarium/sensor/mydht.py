import Adafruit_DHT
import sys

sensor_args = { '11': Adafruit_DHT.DHT11,
		'22': Adafruit_DHT.DHT22 }
if len(sys.argv) == 3 and sys.argv[1] in sensor_args:
    sensor = sensor_args[sys.argv[1]]
    pin = sys.argv[2]
else:
    print('Incorrect Usage')
    print('Example: "sudo python3 mydht.py 11 4" (11:DHT11, 4:GPIO-Pin4)')
    sys.exit(1)

humidity, temperature = Adafruit_DHT.read(sensor, pin)

if humidity is not None and temperature is not None:
    print("{0:0.1f} {1:0.1f}".format(temperature, humidity))
else:
    print("Sensor failure. Check wiring.")