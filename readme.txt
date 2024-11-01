=== WP Math ===
Contributors: Mikoviny
Donate link: http://wpmath.g6.cz/
Tags: math, math publishing, math publisher, counting, calculation
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 0.4.5

Publishing and solving mathematical documents, counting with matrices and creating graphs. Plugin is using <a href="http://www.xm1math.net/phpmathpublisher/">PhpMathPublisher.</a>

== Description ==

This is just Beta version of this Plugin with some Bugs, but I need to report them (<a href="http://wpmath.g6.cz/">http://wpmath.g6.cz/</a>).

I had to rewrite the core function of plugin. In these case UNITS are NOT working. In few days I fix these bugs. 

**News:**

1. Couting with matrices (solving linear equation) 
2. Creating Graphs
3. Math and Trigonometric functions like a^x, floor, round, sin, cos...

**What this plugin can do:**

1. Display mathematical documents. Plugin is using PhpMathPublisher
2. Add, Subtract, Multiply, Divide.
3. Count with matrix
4. Display Graphs
5. Show results.
6. If you add "==" on the end of formula at first it inserted variables and than show result.
7. Converting e-mail in posts and pages to *.png picture.
8. Add form with custom variables for page visitors.
9. Multiple inputs.
10. Static counting
11. Use multiple functions (Ceil, ceil, Floor, floor, Round, round, acos, acosh, asin, asinh,  atan... <a href="http://www.wpmath.g6.cz/functions/">Full list</a>).
12. Basic units NOT WORKING IN 0.4.0. !!!!

= How it works =
* <a href="http://wpmath.g6.cz/">Visit the plugin site</a> 


**What I want to do:**
 
1. Add real units
2. Add some other math functions
3. Add some TinyMC buttons
4. Make it easy to plug-in with your own functions


= Contact: =
* site: http://wpmath.g6.cz

== Installation ==


1. Upload wp-math.zip to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set CHMOD 777 for `/wp-content/plugins/wp-math/img/` and `/wp-content/plugins/wp-math/graphs/`

== Screenshots ==

1. Formulas
2. E-mails
3. Graphs
4. Couting with matrices


== Frequently Asked Questions ==
= How to use graphs =
* &lt;m&gt;line_1=matrix{1}{5}{5 44 87 55 6};line_2=matrix{1}{5}{54 4 7 85 60};Axis_x=matrix{1}{5}{1995 1996 1997 1998 1999}&lt;/m&gt;

* [graph]title: GRAPF TITLE;values:line_1,line_2;X:Axis_x;Y:Axis Y[/graph]


== Changelog ==
= 0.4.5 =
* fixed bug with core function (I hope)

= 0.4.2 =
* fixed bugs with matrices
* fixed bug with result round

= 0.4.1 =
* fixed bug with graph url

= 0.4.0 =
* Creating Graphs
* Add couting with matrices
* UNITS and some Math functions are NOT WORKING

= 0.2.1 =
* Php functions checked. <a href="http://www.wpmath.g6.cz/functions/">Online manual</a>
* Add basic units.
* Add functions Floor,Ceil,Round,Random,a^x, root{10}{1024}, log(number,base), cot()

= 0.2.0 =
* Add functions (acos, acosh, asin, asinh,  atan, atanh, baseconvert, bindec, ceil, cos, cosh, decbin, 
dechex, decoct, exp, floor, fmod, getrandmax, hexdec, hypot, isfinite, isinfinite, isnan, lcgvalue, log, max, 
min, mtgetrandmax, mtrand, mtsrand, octdec, pi, pow, rand, round, sin, sinh, sqrt, srand, tan, tanh)
 

= 0.1.6 beta =
* Optimalizing calculations. Add [static*all] to convert all formulas in document to static formulas. Or surround some formulas with [static][/static] to convert just them. 
* Solved security for [form][/form] 
* Add some settings

= 0.1.3 beta =
* Page visitors can add own variables
* Multiple formulas in one &lt;m&gt;&lt;/m&gt;

= 0.1.2 beta =
* Customize font size
* Solved bug with url

= 0.1.1 beta =
* E-mails in pages and posts replaced by *.png picture
* Some bugs with TinyMC solved

= 0.1 beta =
* Add, Subtract, Multiply, Divide
* = -> show result
* == -> show unknown

