# Composer Autoloading

All right, guys. Confession time. This cool little autoloader idea where we make our class name match our file name and our name space match our directory structure so we can write a really simple autoloader to find it ... That was not my idea. In fact, this idea has been around at php for years, and every modern project follows this rule, which is both nice for consistency and organization and is also nice because we can all autoload our files in the same way.

In fact, this idea of naming your classes and files in this way is called 'psr-0'. There's a group in the phps called the php Fig which comes together and agrees on standards, and psr-0 was the first standard they came out with because obviously, we start counting with 0. It just says that Thou shalt call your class names the same as your file names .php and you should have your directory structures match up with your name spaces. Cool?

Why do you care? You care because instead of having to write this autoloader by hand, you can actually include an outside library that is just going to take care of all of that for us. The library's called 'Composer' and you may have heard of it.

First, let's download it. Go to getcompser.org , and hit download. Then copy the lines up here. If you're on Windows, you might see a slightly different download instructions. Then move into your terminal, open a new tab, and paste those in. This is downloading Composer. It's an executable file, and its main job is actually to help you download PHP packages. Composer's a package manager that we're not going to talk about today. Usually people use Composer to download external libraries they want to use in their project. But it has a second superpower, which is autoloading. So, when you're done, you'll end up with a composer.phar file which is a php executable. We're going to come back to it in a second.

Now, to teach Composer to do the autoloading for us, all you need to do is create a new file called composer.json and we're just going to add a little bit of configuration inside of here; an autoload key, a psr-4 key, and empty quotes set to lib. That's it.

Remember I said this rule is called psr-0? Well psr-4 is a slight amendment to that. So psr-0 and psr-4 basically refer to this idea of naming your classes in a certain way. We're telling Composer that we want it to autoload our files using that convention, and the empty quote here says load every single class, no matter what it looks like, from my lib directory. That's it.

Now, back in the [trentroom 00:04:18], just run php composer.phar install. This normally would download any external packages that we need, but of course we're not using it that way. The second thing it does is it generates some autoload files. Specifically, it creates a new directory called Vendor, and inside of there, a couple files are going to help with autoloading.

The cool part about this is all that we need to do now is inside of bootstrap.php, delete all this stuff and just say require__DIR__vendor/autoload.php which is one of the files that composer just generated for us. You also usually don't commit the Vendor directory to the depository. You have people on Composer install whenever they pull down a project.

So, go back, refresh ours, and we're good to go. As we add more classes and more directories to our lib directory, everything's going to work just fine. And if you guys want to start downloading external libraries into your project via Composer, you can do that, and you can reference those classes in the same way without doing any more work, so this is a cool thing.

