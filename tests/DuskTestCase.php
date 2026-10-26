<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;
use RuntimeException;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     *
     * @return void
     */
    #[\PHPUnit\Framework\Attributes\BeforeClass]
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::useChromedriver(static::chromeDriverPath());

            static::startChromeDriver(['--port=9515']);

            static::waitForChromeDriver();
        }
    }

    /**
     * Wait for Chromedriver to accept connections so the first test does not
     * race the driver's startup, which is slower on cold CI runners.
     *
     * @return void
     */
    protected static function waitForChromeDriver()
    {
        for ($attempt = 0; $attempt < 50; $attempt++) {
            $socket = @fsockopen('127.0.0.1', 9515, $errno, $errstr, 0.2);

            if ($socket !== false) {
                fclose($socket);

                return;
            }

            usleep(100_000);
        }

        throw new RuntimeException(
            'Chromedriver did not accept connections within 5 seconds. '
            .'Exit code: '.static::$chromeProcess?->getExitCode()
            .'. Output: '.static::$chromeProcess?->getOutput()
            .'. Error output: '.static::$chromeProcess?->getErrorOutput()
        );
    }

    /**
     * Locate the Chromedriver binary, accounting for the directory layout
     * used by recent versions of the dusk:chrome-driver command.
     *
     * @return string
     */
    protected static function chromeDriverPath()
    {
        $base = dirname(__DIR__).'/vendor/laravel/dusk/bin';

        foreach (['chromedriver-linux64/chromedriver', 'chromedriver-linux'] as $path) {
            if (is_file("{$base}/{$path}")) {
                $binary = "{$base}/{$path}";

                if (! is_executable($binary)) {
                    chmod($binary, 0755);
                }

                return $binary;
            }
        }

        return "{$base}/chromedriver-linux";
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? 'http://127.0.0.1:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled(): bool
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }
}
