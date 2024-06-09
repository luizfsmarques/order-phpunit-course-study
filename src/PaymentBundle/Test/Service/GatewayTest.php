<?php declare(strict_types=1);

namespace PaymentBundle\Test\Service;

use PaymentBundle\Service\Gateway;
use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PHPUnit\Framework\TestCase;

//I UNDERTOOD THE CONCEPTS ABOURT THE SUBJECT, BUT I DON'T KNOW WHY
// THE SCENERIO TWO AND THREE DIDN'T WORK... FIND THE PROBLEM AFTER...
class GatewayTest extends TestCase
{

    public function testShouldNotPayWhenAuthenticationFail(): void 
    {
        $HttpClientInterface = $this->createMock(HttpClientInterface::class);
        $LoggerInterface = $this->createStub(LoggerInterface::class);
        $user = 'test';
        $password = 'invalid-password';
        $Gateway = new Gateway($HttpClientInterface,$LoggerInterface,$user,$password);
        $name = 'Fernando';
        $creditCardNumber = 5555444488889999;
        $validity = new \DateTime('now');
        $value = 100;
        $token = null;
        $map = [
            [
                'POST',
                Gateway::BASE_URL.'/authenticate',
                [
                    'user'=>$user,
                    'passord'=>$password
                ],
                $token
            ]
        ];

        $HttpClientInterface->expects($this->once())->method('send')->willReturnMap($map);
        
        $paid = $Gateway->pay($name,$creditCardNumber,$validity,$value);

        $this->assertEquals(false,$paid);

    }

    public function testShouldNotPayWhenFailOnGateway(): void 
    {
        $HttpClientInterface = $this->createMock(HttpClientInterface::class);
        $LoggerInterface = $this->createStub(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $Gateway = new Gateway($HttpClientInterface,$LoggerInterface,$user,$password);
        $name = 'Fernando';
        $creditCardNumber = 5555444488889999;
        $validity = new \DateTime('now');
        $value = 100;
        $token = 'meu-token';
        $map = [
            [
                'POST',
                Gateway::BASE_URL.'/authenticate',
                [
                    'user'=>$user,
                    'passord'=>$password
                ],
                $token
            ],
            [
                'POST',
                Gateway::BASE_URL.'/pay',
                [
                    'name'=>$nome,
                    'credit_card_number'=>$creditCardNumber,
                    'validity'=>$validity,
                    'value'=>$value,
                    'token'=>$token
                ],
                ['paid'=>false]
            ]
        ];

        $HttpClientInterface->expects($this->atLeast(2))->method('send')->willReturnMap($map);
        $paid = $Gateway->pay($name,$creditCardNumber,$validity,$value);

        $this->assertEquals(false,$paid);

    }

    public function testShouldSuccessfullyPayWhenGatewayReturnOk(): void 
    {
        $HttpClientInterface = $this->createMock(HttpClientInterface::class);
        $LoggerInterface = $this->createStub(LoggerInterface::class);
        $user = 'test';
        $password = 'valid-password';
        $Gateway = new Gateway($HttpClientInterface,$LoggerInterface,$user,$password);
        $name = 'Fernando';
        $creditCardNumber = 5555444488889999;
        $validity = new \DateTime('now');
        $value = 100;
        $token = 'meu-token';
        $map = [
            [
                'POST',
                Gateway::BASE_URL.'/authenticate',
                [
                    'user'=>$user,
                    'passord'=>$password
                ],
                $token
            ],
            [
                'POST',
                Gateway::BASE_URL.'/pay',
                [
                    'name'=>$nome,
                    'credit_card_number'=>$creditCardNumber,
                    'validity'=>$validity,
                    'value'=>$value,
                    'token'=>$token
                ],
                ['paid'=>true]
            ]
        ];

        $HttpClientInterface->expects($this->atLeast(2))->method('send')->willReturnMap($map);
        $paid = $Gateway->pay($name,$creditCardNumber,$validity,$value);

        $this->assertEquals(true,$paid);

    }

}



/*
namespace PaymentBundle\Test\Service;

use PaymentBundle\Service\Gateway;
use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PHPUnit\Framework\TestCase;

// ALULA DE FAKES
// NÃO SEI QUAL O MOTIVO... MAS O TESTE NÃO FUNCIONOU COMO O ESPERADO
// SEMPRE NO TERCEIRO CENÁRIO O TESTE FALHA... MAS NÃO DEVERIA... NÃO ACHEI O ERRO
// TENTAR DESCOBRIR UMA OUTRA HORA
class GatewayTest extends TestCase
{

    public function testShouldNotPayWhenAuthenticationFail(): void 
    {
        $HttpClientInterface = $this->createMock(HttpClientInterface::class);
        $HttpClientInterface->method('send')->willReturnCallback(
            function($method,$address,$body)
            {
                $this->fakeHttpClientInterface($method,$address,$body);
            }
        );

        $LoggerInterface = $this->createStub(LoggerInterface::class);
        
        $user = 'test';
        $password = 'invalid-password';

        $Gateway = new Gateway($HttpClientInterface,$LoggerInterface,$user,$password);

        $paid = $Gateway->pay(
            'Fernando',5555444488889999,new \DateTime('now'),100
        );

        $this->assertEquals(false,$paid);

    }

    public function testShouldNotPayWhenFailOnGateway(): void 
    {
        $HttpClientInterface = $this->createMock(HttpClientInterface::class);
        $HttpClientInterface->method('send')->willReturnCallback(
            function($method,$address,$body)
            {
                $this->fakeHttpClientInterface($method,$address,$body);
            }
        );

        $LoggerInterface = $this->createStub(LoggerInterface::class);
        
        $user = 'test';
        $password = 'valid-password';

        $Gateway = new Gateway($HttpClientInterface,$LoggerInterface,$user,$password);

        $paid = $Gateway->pay(
            'Fernando',8888999988885555,new \DateTime('now'),100
        );

        $this->assertEquals(false,$paid);

    }

    public function testShouldSuccessfullyPayWhenGatewayReturnOk(): void 
    {
        $HttpClientInterface = $this->createMock(HttpClientInterface::class);
        $HttpClientInterface->method('send')->willReturnCallback(
            function($method,$address,$body)
            {
                $this->fakeHttpClientInterface($method,$address,$body);
            }
        );

        $LoggerInterface = $this->createStub(LoggerInterface::class);
        
        $user = 'test';
        $password = 'valid-password';

        $Gateway = new Gateway($HttpClientInterface,$LoggerInterface,$user,$password);

        $paid = $Gateway->pay(
            'Fernando',8888999988889999,new \DateTime('now'),100
        );

        $this->assertEquals(true,$paid);

    }

    public function fakeHttpClientInterface(string $method,string $address, array $body)
    {
        switch($address)
        {
            case Gateway::BASE_URL . '/authenticate':
                if($body['password'] !== 'valid-password')
                {
                    return false;
                }
        
                return 'meu-token';
                return null;
                break;
            case Gateway::BASE_URL . '/pay':
                if($body['credit_card_number'] === 8888999988889999 )
                {
                    return ['paid'=>true];
                }

                return ['paid'=>false];
                break;
        }
        

    }




}
*/