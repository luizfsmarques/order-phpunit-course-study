<?php declare(strict_types = 1);

namespace OrderBundle\Test\Service;

use OrderBundle\Service\BadWordsValidator;
use OrderBundle\Repository\BadWordsRepository;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

// Aqui crio o teste usando a maneira de criar stub do PHP Unit
class BadWordsValidatorTest extends TestCase
{
    #[DataProvider('badWordsDataProvider')]
    public function testHasBadWords( array $badWordsList, string $text, bool $foundBadWords ): void
    {
        $BadWordsRepository = $this->createMock( BadWordsRepository::class );
        $BadWordsRepository->method('findAllAsArray')->willReturn($badWordsList);
        $BadWordsValidator = new BadWordsValidator($BadWordsRepository);
        $hasBadWord = $BadWordsValidator->hasBadWords($text);
        $this->assertEquals($foundBadWords,$hasBadWord);   
    }

    public static function badWordsDataProvider(): array
    {
        $badWordsList = ['bobo','chule','besta'];
        return [
            'shouldFindWhenHasBadWords'=>[
                'badWordsList'=>$badWordsList,
                'text'=>'Essa mensagem tem bobo',
                'foundBadWords'=>true
            ],
            'shouldNotFindWhenHasNotBadWords'=>[
                'badWordsList'=>$badWordsList,
                'text'=>'Essa mensagem tem nada',
                'foundBadWords'=>false
            ],
            'shouldNotFindWhenTextIsEmpty'=>[
                'badWordsList'=>$badWordsList,
                'text'=>'',
                'foundBadWords'=>false
            ],
            'shouldNotFindWhenBadWordsListIsEmpty'=>[
                'badWordsList'=>[],
                'text'=>'Essa mensagem tem bobo',
                'foundBadWords'=>false
            ],
        ];
    }

}





//Maneira de fazer manual, sem usar o PHP Unit
// namespace OrderBundle\Test\Service;

// use OrderBundle\Service\BadWordsValidator;
// // use OrderBundle\Repository\BadWordsRepository;
// use OrderBundle\Test\Service\BadWordsRepositoryStub;
// use PHPUnit\Framework\Attributes\DataProvider;
// use PHPUnit\Framework\TestCase;

// class BadWordsValidatorTest extends TestCase
// {

//     public function testHasBadWords()
//     {

//         $BadWordsRepository = new BadWordsRepositoryStub();
//         $BadWordsValidator = new BadWordsValidator(  $BadWordsRepository );
//         $hasBadWord = $BadWordsValidator->hasBadWords('Essa mensagem tem bobo');
//         $this->assertEquals(true,$hasBadWord); 
        
//     }


// }