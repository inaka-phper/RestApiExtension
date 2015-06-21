<?php
namespace Behat\RestApiExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use GuzzleHttp\ClientInterface;

/**
 * Guzzle-aware contexts initializer.
 *
 * Sets Guzzle client instance to the ApiClientAwareContext.
 *
 * @author Frédéric G. Marand <fgm@osinet.fr>
 */
class RestApiAwareInitializer implements ContextInitializer
{

    private $parameters;
    /**
     * Initializes initializer.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }
    /**
     * Initializes provided context.
     *
     * @param Context $context
     */
    public function initializeContext(Context $context)
    {
            $context->setParameters($this->parameters);
    }
}
