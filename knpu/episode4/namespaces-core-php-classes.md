# Namespaces and Core PHP Classes

Let's close all these tabs and open up container. A reminder from last time, we actually created two different ways to load ship objects. One of them is from a Json file called JsonFileShipStorage and the other one is from the database using PDO. You can actually just switch and use either of these and the system doesn't care at all because of this cool ship storage interface. Anyways, I just changed it, let's go back, refresh and [woah 00:00:35], new error. Service slash PDO not fount, container line 28. Let's check that out.

Here we see a classic undefined class PDO and so far the answer to this is always been, "Oh I must have forgotten a Use statement." I referenced a class, this class lives in some other names space so I probably need to reference it. Here's the kicker though, PDO is a core [PHP 00:01:04] class, it does not live in a namespace. In other-words it's like a file that lives at the root of you file system.

Really the problem is the same as before, when PHPC is the class PDO here, it looks at the top of the class for a Use statement that ends in PDO, doesn't find one so it assumes that PDO lives in the service namespace when in fact PDO lives in the root of the namespace.

The way to fix this is to add a slash in front of the PDO which should feel very natural, again, if you think of namespace like a directory structure. This is like us saying LS slash PDO. It doesn't matter what directory we're in, when we do that it means from the root of the namespace so I add up here slash PDO and down here, where we reference it again.

This is true of all core PHP classes, they do not live in namespaces so when you reference them, you'll reference them as slash PDO. Now, technically, if you were inside of a file that didn't' have a namespace, you don't have to do that but it's always safe to say slash new slash PDO. That will work inside of a namespace file or a non-namespace file. It's just more portable.

If you refresh now you still get an error and this is for the same reason but this error is less clear. Argument 1 pass to PDO [shipshotageconstruct 00:02:58] must be an instance of service slash PDO instance of PDO given. This should jump out at you, "Instance of service PDO." So PHP thinks that argument 1 to PDO shipstorage should be this nonsense class, service slash PDO.

There reason is that in PDO shipshorage we have type hinted our construct argument with PDO and of course to PHP that looks like service slash PDO so you need to put the slash in front of that as well.

I'm spending time on this because these are the mistakes that you'll make with name spaces in the very beginning and they're annoying but the answer is almost always the same. You either forgot a use statement or if you're referencing a core PHP class you forgot the opening slash.

We'll do the same thing down here and down here. Finally we can refresh and life is good. You just saw the ugliest parts of namespaces.

