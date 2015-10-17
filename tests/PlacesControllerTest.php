<?php

use TypiCMS\Modules\Places\Models\Place;

class PlacesControllerTest extends TestCase
{
    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/places');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = ['fr.title' => 'test', 'fr.slug' => ''];
        $this->call('POST', 'admin/places', $input);
        $this->assertRedirectedToRoute('admin.places.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Place();
        $object->id = 1;
        Place::shouldReceive('create')->once()->andReturn($object);
        $input = ['fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'status' => 0];
        $this->call('POST', 'admin/places', $input);
        $this->assertRedirectedToRoute('admin.places.edit', ['id' => 1]);
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Place();
        $object->id = 1;
        Place::shouldReceive('create')->once()->andReturn($object);
        $input = ['fr.title' => 'test', 'fr.slug' => 'test', 'fr.body' => '', 'status' => 0, 'exit' => true];
        $this->call('POST', 'admin/places', $input);
        $this->assertRedirectedToRoute('admin.places.index');
    }
}
