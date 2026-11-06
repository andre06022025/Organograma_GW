<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A rota raiz redireciona para o organograma.
     */
    public function test_the_root_route_redirects_to_the_organograma(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('organograma.index'));
    }
}
