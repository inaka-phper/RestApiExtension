<?php
namespace Behat\RestApiExtension\Context\Initializer;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\Initializer\ContextInitializer;
use GuzzleHttp\ClientInterface;
use Behat\RestApiExtension\Context\RestApiContext;

/**
 *
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
            if ($context instanceof RestApiContext) {
                $context->setParameters($this->parameters);
            }
    }
}
