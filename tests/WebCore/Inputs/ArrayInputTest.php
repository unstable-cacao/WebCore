<?php
namespace WebCore\Inputs;


use Objection\TEnum;
use PHPUnit\Framework\TestCase;


class ArrayInputTest extends TestCase
{
	/**
	 * @expectedException \Exception
	 */
	public function test_NotValidSource_ExceptionThrown()
	{
		$subject = new ArrayInput('');
	}
	
	public function test_get_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([1], $subject->get([1]));
	}
	
	public function test_get_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->get([1]));
	}
	
	public function test_get_ReturnSource()
	{
		$subject = new ArrayInput([2, 3]);
		
		self::assertEquals([2, 3], $subject->get([1]));
	}
	
	public function test_getInt_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([1], $subject->getInt([1]));
	}
	
	public function test_getInt_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->getInt([1]));
	}
	
	public function test_getInt_AllValid_ReturnIntArray()
	{
		$subject = new ArrayInput(['1', '2']);
		
		self::assertEquals([1, 2], $subject->getInt([3]));
	}
	
	public function test_getInt_NotAllValid_ReturnDefault()
	{
		$subject = new ArrayInput(['1', 'test']);
		
		self::assertEquals([3], $subject->getInt([3]));
	}
	
	public function test_getFloat_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([1.1], $subject->getFloat([1.1]));
	}
	
	public function test_getFloat_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->getFloat([1.1]));
	}
	
	public function test_getFloat_AllValid_ReturnFloatArray()
	{
		$subject = new ArrayInput(['1.1', '2.2']);
		
		self::assertEquals([1.1, 2.2], $subject->getFloat([3.3]));
	}
	
	public function test_getFloat_NotAllValid_ReturnDefault()
	{
		$subject = new ArrayInput(['1.1', 'test']);
		
		self::assertEquals([3.3], $subject->getFloat([3.3]));
	}
	
	public function test_getBool_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([true], $subject->getBool([true]));
	}
	
	public function test_getBool_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->getBool([true]));
	}
	
	public function test_getBool_AllValid_ReturnBoolArray()
	{
		$subject = new ArrayInput(['1', '']);
		
		self::assertEquals([true, false], $subject->getBool([true]));
	}
	
	public function test_getBool_NotAllValid_ReturnDefault()
	{
		$subject = new ArrayInput(['1', [1]]);
		
		self::assertEquals([false], $subject->getBool([false]));
	}
	
	public function test_getEnum_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals(['a'], $subject->getEnum(['a', 'b'], ['a']));
	}
	
	public function test_getEnum_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->getEnum(['a', 'b'], ['a']));
	}
	
	public function test_getEnum_AllValidEnumArray_ReturnArray()
	{
		$subject = new ArrayInput(['a', 'b']);
		
		self::assertEquals(['a', 'b'], $subject->getEnum(['a', 'b'], ['a']));
	}
	
	public function test_getEnum_NotAllValidEnumArray_ReturnDefault()
	{
		$subject = new ArrayInput(['a', 'c']);
		
		self::assertEquals(['d'], $subject->getEnum(['a', 'b'], ['d']));
	}
	
	public function test_getEnum_AllValidTEnum_ReturnArray()
	{
		$subject = new ArrayInput(['b']);
		
		self::assertEquals(['b'], $subject->getEnum(ArrayInputTestHelper_B::class, ['a']));
	}
	
	public function test_getEnum_NotAllValidTEnum_ReturnDefault()
	{
		$subject = new ArrayInput(['b', 'c']);
		
		self::assertEquals(['a'], $subject->getEnum(ArrayInputTestHelper_B::class, ['a']));
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_getEnum_EnumValuesNotValid_ExceptionThrown()
	{
		$subject = new ArrayInput(['b', 'c']);
		
		$subject->getEnum(ArrayInputTestHelper_A::class, ['a']);
	}
	
	public function test_filterInt_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([1], $subject->filterInt([1]));
	}
	
	public function test_filterInt_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->filterInt([1]));
	}
	
	public function test_filterInt_AllValid_ReturnAllIntArray()
	{
		$subject = new ArrayInput(['1', '2']);
		
		self::assertEquals([1, 2], $subject->filterInt([3]));
	}
	
	public function test_filterInt_NotAllValid_ReturnOnlyValid()
	{
		$subject = new ArrayInput(['1', 'test']);
		
		self::assertEquals([1], $subject->filterInt([3]));
	}
	
	public function test_filterFloat_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([1.1], $subject->filterFloat([1.1]));
	}
	
	public function test_filterFloat_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->filterFloat([1.1]));
	}
	
	public function test_filterFloat_AllValid_ReturnAllFloatArray()
	{
		$subject = new ArrayInput(['1.1', '2.2']);
		
		self::assertEquals([1.1, 2.2], $subject->filterFloat([3.3]));
	}
	
	public function test_filterFloat_NotAllValid_ReturnOnlyValid()
	{
		$subject = new ArrayInput(['1.1', 'test']);
		
		self::assertEquals([1.1], $subject->filterFloat([3.3]));
	}
	
	public function test_filterBool_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals([true], $subject->filterBool([true]));
	}
	
	public function test_filterBool_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->filterBool([true]));
	}
	
	public function test_filterBool_AllValid_ReturnAllBoolArray()
	{
		$subject = new ArrayInput(['1', '']);
		
		self::assertEquals([true, false], $subject->filterBool([true]));
	}
	
	public function test_filterBool_NotAllValid_ReturnOnlyValid()
	{
		$subject = new ArrayInput(['1', [1]]);
		
		self::assertEquals([true], $subject->filterBool([false]));
	}
	
	public function test_filterEnum_Null_ReturnDefault()
	{
		$subject = new ArrayInput(null);
		
		self::assertEquals(['a'], $subject->filterEnum(['a', 'b'], ['a']));
	}
	
	public function test_filterEnum_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->filterEnum(['a', 'b'], ['a']));
	}
	
	public function test_filterEnum_AllValidEnumArray_ReturnArray()
	{
		$subject = new ArrayInput(['a', 'b']);
		
		self::assertEquals(['a', 'b'], $subject->filterEnum(['a', 'b'], ['a']));
	}
	
	public function test_filterEnum_NotAllValidEnumArray_ReturnFiltered()
	{
		$subject = new ArrayInput(['a', 'c']);
		
		self::assertEquals(['a'], $subject->filterEnum(['a', 'b'], ['d']));
	}
	
	public function test_filterEnum_AllValidTEnum_ReturnArray()
	{
		$subject = new ArrayInput(['b']);
		
		self::assertEquals(['b'], $subject->filterEnum(ArrayInputTestHelper_B::class, ['a']));
	}
	
	public function test_filterEnum_NotAllValidTEnum_ReturnFiltered()
	{
		$subject = new ArrayInput(['b', 'c']);
		
		self::assertEquals(['b'], $subject->filterEnum(ArrayInputTestHelper_B::class, ['a']));
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_filterEnum_EnumValuesNotValid_ExceptionThrown()
	{
		$subject = new ArrayInput(['b', 'c']);
		
		$subject->filterEnum(ArrayInputTestHelper_A::class, ['a']);
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_require_Null_ExceptionThrown()
	{
		$subject = new ArrayInput(null);
		
		$subject->require();
	}
	
	public function test_require_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->require());
	}
	
	public function test_require_ReturnSource()
	{
		$subject = new ArrayInput([2, 3]);
		
		self::assertEquals([2, 3], $subject->require());
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireInt_Null_ExceptionThrown()
	{
		$subject = new ArrayInput(null);
		
		$subject->requireInt();
	}
	
	public function test_requireInt_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->requireInt());
	}
	
	public function test_requireInt_AllValid_ReturnIntArray()
	{
		$subject = new ArrayInput(['1', '2']);
		
		self::assertEquals([1, 2], $subject->requireInt());
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireInt_NotAllValid_ExceptionThrown()
	{
		$subject = new ArrayInput(['1', 'test']);
		
		$subject->requireInt();
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireFloat_Null_ExceptionThrown()
	{
		$subject = new ArrayInput(null);
		
		$subject->requireFloat();
	}
	
	public function test_requireFloat_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->requireFloat());
	}
	
	public function test_requireFloat_AllValid_ReturnFloatArray()
	{
		$subject = new ArrayInput(['1.1', '2.2']);
		
		self::assertEquals([1.1, 2.2], $subject->requireFloat());
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireFloat_NotAllValid_ExceptionThrown()
	{
		$subject = new ArrayInput(['1.1', 'test']);
		
		$subject->requireFloat();
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireBool_Null_ExceptionThrown()
	{
		$subject = new ArrayInput(null);
		
		$subject->requireBool();
	}
	
	public function test_requireBool_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->requireBool());
	}
	
	public function test_requireBool_AllValid_ReturnBoolArray()
	{
		$subject = new ArrayInput(['1', '']);
		
		self::assertEquals([true, false], $subject->requireBool());
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireBool_NotAllValid_ExceptionThrown()
	{
		$subject = new ArrayInput(['1', [1]]);
		
		$subject->requireBool();
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireEnum_Null_ExceptionThrown()
	{
		$subject = new ArrayInput(null);
		
		$subject->requireEnum(['a', 'b']);
	}
	
	public function test_requireEnum_EmptyArray_ReturnEmptyArray()
	{
		$subject = new ArrayInput([]);
		
		self::assertEmpty($subject->requireEnum(['a', 'b']));
	}
	
	public function test_requireEnum_AllValidEnumArray_ReturnArray()
	{
		$subject = new ArrayInput(['a', 'b']);
		
		self::assertEquals(['a', 'b'], $subject->requireEnum(['a', 'b']));
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireEnum_NotAllValidEnumArray_ExceptionThrown()
	{
		$subject = new ArrayInput(['a', 'c']);
		
		$subject->requireEnum(['a', 'b']);
	}
	
	public function test_requireEnum_AllValidTEnum_ReturnArray()
	{
		$subject = new ArrayInput(['b']);
		
		self::assertEquals(['b'], $subject->requireEnum(ArrayInputTestHelper_B::class));
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireEnum_NotAllValidTEnum_ExceptionThrown()
	{
		$subject = new ArrayInput(['b', 'c']);
		
		$subject->requireEnum([ArrayInputTestHelper_B::class]);
	}
	
	/**
	 * @expectedException \Exception
	 */
	public function test_requireEnum_EnumValuesNotValid_ExceptionThrown()
	{
		$subject = new ArrayInput(['b', 'c']);
		
		$subject->requireEnum(ArrayInputTestHelper_A::class);
	}
}


class ArrayInputTestHelper_A {}

class ArrayInputTestHelper_B
{
	use TEnum;
	
	
	const B = 'b';
}