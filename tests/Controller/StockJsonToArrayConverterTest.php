<?php


namespace Tests\Controller;


class StockJsonToArrayConverterTest extends BaseOrderControllerTest
{
    public function testJsonToArrayConverterWithWrongInput()
    {
        $this->expectException(\JsonException::class);
        $this->orderController->convertJSONParameterToArray('{"1": }');
    }

    public function testJsonToArrayConverterWithoutElements()
    {
        $this->expectException(\JsonException::class);
        $this->orderController->convertJSONParameterToArray('{}');
    }

    public function testJsonToArrayConverterWithArrayInput()
    {
        $this->expectException(\JsonException::class);
        $this->orderController->convertJSONParameterToArray('[1 => 2]');
    }

    public function testJsonToArrayConverterReturnsFine()
    {
        $expected = [1 => 2, 3 => 4];
        $actual = $this->orderController->convertJSONParameterToArray(json_encode($expected));
        $this->assertEquals($expected, $actual);

        $expected = [1 => 2, 3 => 4];
        $actual = $this->orderController->convertJSONParameterToArray('{"1": 2, "3": 4}');
        $this->assertEquals($expected, $actual);
    }
}