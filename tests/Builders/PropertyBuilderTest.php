<?php

namespace Spatie\IcalendarGenerator\Tests\Builders;

use Spatie\IcalendarGenerator\Builders\PropertyBuilder;
use Spatie\IcalendarGenerator\Properties\Parameter;
use Spatie\IcalendarGenerator\Properties\TextProperty;
use Spatie\IcalendarGenerator\Tests\TestCase;
use Spatie\IcalendarGenerator\Tests\TestClasses\DummyProperty;

class PropertyBuilderTest extends TestCase
{
    /** @test */
    public function it_will_build_the_property_correctly()
    {
        $property = new DummyProperty('location', 'Antwerp');

        $this->assertEquals(
            ['location:Antwerp'],
            (new PropertyBuilder($property))->build()
        );
    }

    /** @test */
    public function it_will_build_the_parameters_correctly()
    {
        $property = new DummyProperty('location', 'Antwerp');

        $property->addParameter(
            new Parameter('street', 'Samberstraat')
        );

        $this->assertEquals(
            ['location;street=Samberstraat:Antwerp'],
            (new PropertyBuilder($property))->build()
        );
    }

    /** @test */
    public function it_will_build_the_property_according_to_specific_rules()
    {
        $property = new TextProperty('location', 'Antwerp, Belgium');

        $this->assertEquals(
            ['location:Antwerp\, Belgium'],
            (new PropertyBuilder($property))->build()
        );
    }

    /** @test */
    public function it_will_use_the_alias_of_a_property_when_given()
    {
        $property = TextProperty::create('location', 'Antwerp, Belgium')->addAlias('geo');

        $this->assertEquals(
            [
                'location:Antwerp\, Belgium',
                'geo:Antwerp\, Belgium',
            ],
            (new PropertyBuilder($property))->build()
        );
    }
}
