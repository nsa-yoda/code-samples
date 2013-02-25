# Done for MITx 6.00x (Intro to CompSci) on edx

print("Please think of a number between 0 and 100!")

c = "Enter 'h' to indicate the guess is too high. Enter 'l' to indicate the guess is too low. Enter 'c' to indicate I guessed correctly."
minimum = 0
maximum = 100
g = ''
done = 'False'

guess = int((maximum + minimum) / 2)

#If the guess is bigger than the number, then the number must be smaller than the guess, so we set the maximum guess bound to be the current guess.
#If the guess is smaller than the number, then we set the maximum to be the highest number possible and the minimum to be the guess.

while(done != 'True'):
    print("Is your secret number " + str(guess) + "?")
    g = str(raw_input(c))

    if g == 'l':
        minimum = guess
    elif g == 'h':
        maximum = guess
    elif g == 'c':
        print("Game over. Your secret number was: " + str(guess))
        done = 'True'
        break
    else:
        print("Sorry, I did not understand your input.")

    guess = int((maximum + minimum) / 2)
