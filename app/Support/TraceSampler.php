<?php

namespace App\Support;

use Sentry\Tracing\SamplingContext;

class TraceSampler
{
    /**
     * Determine the trace sample rate for the given context. Requests from
     * uptime monitors are excluded, and transactions with a sampled parent
     * are always included.
     */
    public static function sample(SamplingContext $context): float
    {
        if (request()->has('uptime')) {
            return 0.0;
        }

        if ($context->getParentSampled()) {
            return 1.0;
        }

        return (float) config('sentry.traces_sample_rate', 0.0);
    }
}
