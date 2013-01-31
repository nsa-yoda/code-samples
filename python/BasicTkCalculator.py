#! /usr/bin/env python

# Import libraries
from Tkinter import *
import math

# The globals that need to be updated constantly 
global master
global updateLabel
global updatedString

def clear():
    global updateLabel
    global updatedString
    
    # Clear the label & the string
    updateLabel.set("")
    updatedString = ""

def addToStack(concat):
    global master
    global updateLabel
    global updatedString

    # Concatenate the string
    updatedString = str(updatedString) + str(concat)

    # IF we detect an equal sign, evaluate
    if(concat == "="):
        updatedString = updatedString.replace("=","")
        updatedString = float(eval(updatedString))

    # Update the label
    updateLabel.set(str(updatedString))

def main():
    # Start a the parent Tkinter object
    global master
    global updateLabel
    global updatedString
    master = Tk()   

    # Settings
    master.geometry("729x500")
    master.wm_title("Basic Calculator")

    # Set up the autoupdate text
    updateLabel = StringVar()
    updatedString = ""

    # Show the calculator
    calcScreen = Label(master, textvariable=updateLabel, bg="black", fg="green", font=("Courier New",16), bd=2, height=2, 
               width=45).grid(row=0, stick=N, columnspan=4)
    
    # Set initial value of label
    updateLabel.set(0)

    # Set up buttons
    button = Button(master, width=14, height=4, font=("Courier New", 14), text=0, command=lambda m=0: addToStack(0)).grid(row=2, column=0)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=1, command=lambda m=1: addToStack(1)).grid(row=2, column=1)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=2, command=lambda m=2: addToStack(2)).grid(row=2, column=2)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text="+", command=lambda m="+": addToStack("+")).grid(row=2, column=3)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=3, command=lambda m=3: addToStack(3)).grid(row=3, column=0)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=4, command=lambda m=4: addToStack(4)).grid(row=3, column=1)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=5, command=lambda m=5: addToStack(5)).grid(row=3, column=2)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text="-", command=lambda m="-": addToStack("-")).grid(row=3, column=3)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=6, command=lambda m=6: addToStack(6)).grid(row=4, column=0)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=7, command=lambda m=7: addToStack(7)).grid(row=4, column=1)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=8, command=lambda m=8: addToStack(8)).grid(row=4, column=2)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text="/", command=lambda m="/": addToStack("/")).grid(row=4, column=3)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=9, command=lambda m=9: addToStack(9)).grid(row=5, column=0)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text=".", command=lambda m=".": addToStack(".")).grid(row=5, column=1)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text="*", command=lambda m="*": addToStack("*")).grid(row=5, column=2)
        button = Button(master, width=14, height=4, font=("Courier New", 14), text="=", command=lambda m="=": addToStack("=")).grid(row=5, column=3)
    button = Button(master, width=45, height=1, font=("Courier New", 14), text="Clear", command=clear).grid(row=6, column=1, columnspan=4)

    master.mainloop()

# Call the program
main()
