# UdaCLI

This allows you to submit code to Udacity from your commandline

It's been tested on Debian Wheezy running PHP 5.4

## Installation

Install Goutte and dependancies by executing

    php composer.phar install


Clone the distribution config to a local config file

	cp app/config/config.php.dist app/config/config.php


Edit the $udacityUser variable in app/config/config.php to use your username and password


## Operation

Test code on udacity by running the following command

	php src/submit.php <evaluationId> <submissionDirectory>

*Evaluation ID* can be obtained from the URL of the problem set on Udacity. It is prefixed
by the letter 'm',

    https://www.udacity.com/course/viewer#!/c-cs344/l-77202674/e-80151292/m-81489114

In the above example, the evaluation ID is 81489114

*Submission directory* is the directory containing your files of code. Unit2 of c-cs344 is
included as an example in data/c-cs344/Unit2

We can submit a solution for Unit2 using the following command

	php src/submit.php 81489114 data/c-cs344/Unit2/

***Warning: If you use this, save the code you have on Udacity to files first, as this may
result in previously submitted solutions being reset***


Note that this script is largely a hack, and hasn't been tested thoroughly or written
particularly tidily.


If you want to improve this, send me a pull request :)

If you have a suggestion or request, poke me on my blog: http://tobias.wooldridge.id.au/blog/2013/submit-to-udacity-from-your-commandline
