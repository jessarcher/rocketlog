<p align="center"><a href="https://rocketlog.app" target="_blank"><img src="https://raw.githubusercontent.com/jessarcher/rocketlog/main/public/images/rocketlog.svg" width="400"></a></p>

## Self-hosting

One of the original goals of RocketLog is to allow people to self-host it if they didn't feel comfortable using a hosted solution.

While you're free to give this a go, it will currently be a bit of pain due to the use of a licenced subscription billing package (Laravel Spark) which is needed for the hosted version. You could probably remove this package, and remove all traces from the code, but you won't be able to update it easily.

I will try to improve this in the future, especially if there is demand.

In the mean time, you can still view and learn from the source code, and even PR bugfixes and features to the hosted version!

## Security

If you discover any security related issues, please email jess@jessarcher.com instead of using the issue tracker.

## A note on code style

One of my hopes for this project is that it can show others what a working application looks like. However there are a few important things to note:

* I believe in the ["rule of three"](https://javascript.plainenglish.io/the-rule-of-three-refactoring-rule-every-great-developer-knows-6e910a8b02d8). The project is still early days so there is a lot of duplicate code that hasn't yet earned an abstraction.
* This is my first real application using Inertia.js so there are potentially many things that aren't idiomatic.
* My front-end testing needs work!
* Some of the front-end component design doesn't (yet) follow best practices.
