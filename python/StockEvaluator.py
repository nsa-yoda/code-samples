#! /usr/bin/env python

import math, sys, locale

# Set locale because we want decimals
locale.setlocale(locale.LC_ALL, "")

def main():
    print "Welcome to the Stock Evaluator"
    askPrice = float(raw_input("Please enter the current Ask price: "))
    purchasingPower = float(float(raw_input("How much $ is available for purchase? ")) - 9.99)
    maxPurchase = purchasingPower / askPrice
    
    if(purchasingPower < askPrice):
        print "\nSorry, you don't have enough money to purchase that stock.\n"
        print "-" * 80 + "\n"
        print "-" * 80 + "\n"
        main()
    
    print "\nExcellent. Assuming E*TRADE's $9.99 fee, you only have $" + str(purchasingPower) + " purchasing power.\n"
    print "Total stocks you can purchase: " + locale.format("%d", maxPurchase, grouping=True) + "\n"
    
    newAsk = raw_input("Modify to what Ask price to see benefit? ")
    
    if(newAsk):
        print "\n  New Ask price set to " + str(newAsk)
        print "\n  You purchased " + str(locale.format("%d", maxPurchase, grouping=True))
        print "\n  If you sold all stocks, you'd make $" + str(float(maxPurchase) * float(newAsk))
        print "\n  This is a profit of " + str(((float(maxPurchase) * float(newAsk))) - float(purchasingPower + 9.99))

main()
