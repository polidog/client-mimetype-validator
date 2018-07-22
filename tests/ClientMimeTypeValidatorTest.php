<?php

namespace Polidog\Validator\Constraints\Test;


use Polidog\Validator\Constraints\ClientMimeType;
use Polidog\Validator\Constraints\ClientMimeTypeValidator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class ClientMimeTypeValidatorTest extends ConstraintValidatorTestCase
{
    protected $path;

    protected function setUp()
    {
        parent::setUp();
        $this->path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'ClientMimeTypeValidatorTest';
    }

    protected function tearDown()
    {
        parent::tearDown();

        if (file_exists($this->path)) {
            unlink($this->path);
        }

        $this->path = null;
    }


    protected function createValidator()
    {
        return new ClientMimeTypeValidator();
    }

    public function testCsvValidate()
    {
        file_put_contents($this->path, '1');
        $object = new UploadedFile($this->path, 'test.csv', 'text/csv', 0, true);
        $this->validator->validate($object, new ClientMimeType(['mimeTypes' => 'text/csv']));
        $this->assertNoViolation();
    }

    public function testNoCsvValidate()
    {
        file_put_contents($this->path, '1');
        $object = new UploadedFile($this->path, 'test.csv','text/csv', 0, true);
        $this->validator->validate($object, new ClientMimeType(['mimeTypes' => 'text/plain']));
        $this->assertCountViolation(1);
    }

    protected function assertCountViolation($i)
    {
        $this->assertSame($i, $violationsCount = count($this->context->getViolations()), sprintf('0 violation expected. Got %u.', $violationsCount));
    }

}