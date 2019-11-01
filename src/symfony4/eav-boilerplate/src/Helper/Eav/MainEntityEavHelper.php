<?php
/**
 * Created by PhpStorm.
 * User: michele
 * Date: 20/09/2019
 * Time: 17:58
 */

namespace App\Helper\Eav;


use App\Entity\MainEntity;
use App\Entity\MainEntityAttribute;
use App\Entity\MainEntityAttributeOption;
use App\Entity\MainEntityAttributeValue;
use App\Entity\StoreProduct;
use App\Enum\AttributeTypeEnum;
use App\Enum\MainEntityAttributeTypeEnum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class MainEntityEavHelper
{
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param                        $product
     * @param                        $attributeCode
     * @param                        $value
     * @param EntityManagerInterface $em
     *
     * @throws \Exception
     */
    public static function set($product, $attributeCode, $value, EntityManagerInterface $em)
    {
        $attribute = $em->getRepository(MainEntityAttribute::class)->findOneBy([
            'code' => $attributeCode,
        ]);
        
        $toDetach = [];
        
        if (!$attribute) {
            throw new \Exception(sprintf("Attribute with code '%s' does not exists", $attributeCode));
        }
        
        if ($attribute->getMultiple()) {
            
            if (!is_array($value)) {
                $value = [$value];
            }
            $value = array_values($value);
            
            $attributeValues = $em->getRepository(MainEntityAttributeValue::class)->findBy([
                'attribute' => $attribute,
                'product'   => $product,
            ]);
            
            $attributeIndex = 0;
            foreach ($attributeValues as $attributeValue) {
                if (isset($value[$attributeIndex])) {
                    $attributeValue->setValue(self::parseValueToSave($value[$attributeIndex], $attribute));
                } else {
                    $em->remove($attributeValue);
                }
                $attributeIndex++;
                $toDetach[] = $attributeValue;
            }
            
            for ($i = $attributeIndex; $i < count($value); $i++) {
                $attributeValue = new MainEntityAttributeValue();
                $attributeValue->setAttribute($attribute)
                    ->setPosition($i)
                    ->setMainEntity($product)
                    ->setValue(self::parseValueToSave($value[$i], $attribute));
                $em->persist($attributeValue);
                $toDetach[] = $attributeValue;
            }
            $em->flush();
        } else {
            $attributeValue = $em->getRepository(MainEntityAttributeValue::class)->findOneBy([
                'attribute' => $attribute,
                'product'   => $product,
            ]);
            
            if (!$attributeValue) {
                $attributeValue = new MainEntityAttributeValue();
                $attributeValue->setAttribute($attribute)
                    ->setProduct($product)
                    ->setPosition(0);
                $em->persist($attributeValue);
            }
            
            $attributeValue->setValue(self::parseValueToSave($value, $attribute));
            
            $em->flush();
            $toDetach[] = $attributeValue;
        }
        $toDetach[] = $attribute;
        
        foreach ($toDetach as $d) {
            $em->detach($d);
        }
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param $value
     * @param $attribute
     *
     * @return mixed
     */
    protected function parseValueToGet($value, $attribute)
    {
        switch ($attribute->getType()) {
            case MainEntityAttributeTypeEnum::DATETIME_TYPE:
                $d = new \DateTime();
                $d->setTimestamp($value);
                $value = $d;
                break;
        }
        
        return $value;
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param $value
     * @param $attribute
     *
     * @return mixed
     */
    protected function parseValueToSave($value, $attribute)
    {
        switch ($attribute->getType()) {
            case MainEntityAttributeTypeEnum::DATETIME_TYPE:
                $value = $value->getTimestamp();
                break;
        }
        
        return $value;
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param                        $product
     * @param                        $attributeCode
     * @param EntityManagerInterface $em
     * @param null                   $locale
     *
     * @return array|null|string
     * @throws \Exception
     */
    public static function get($product, $attributeCode, EntityManagerInterface $em, $locale = null)
    {
        $attribute = $em->getRepository(MainEntityAttribute::class)->findOneBy([
            'code' => $attributeCode,
        ]);
        
        if (!$attribute) {
            throw new \Exception(sprintf("Attribute with code '%s' does not exists", $attributeCode));
        }
        
        if ($attribute->getMultiple()) {
            
            $value = [];
            
        } else {
            $attributeValue = $em->getRepository(MainEntityAttributeValue::class)->findOneBy([
                'attribute' => $attribute,
                'product'   => $product,
            ]);
            
            $value = null;
            
            if ($attributeValue) {
                switch ($attribute->getType()) {
                    case AttributeTypeEnum::SELECT_TYPE:
                        $optionId = $attributeValue->getValue();
                        $option = $em->getRepository(MainEntityAttributeOption::class)->find($optionId);
                        $value = $option->translate($locale)->getName();
                        if (!$locale || empty($value)) {
                            $value = $option->getName();
                        }
                        break;
                    default:
                        $value = $attributeValue->translate($locale)->getValue();
                        if (!$locale || empty($value)) {
                            $value = $attributeValue->getValue();
                        }
                        break;
                }
            }
            
        }
        
        return $value;
    }
    
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param                        $product
     * @param                        $values
     * @param EntityManagerInterface $em
     *
     * @throws \Exception
     */
    public static function setValues($product, $values, EntityManagerInterface $em)
    {
        $toDetachs = [];
        foreach ($values as $attributeCode => $value) {
            
            $attribute = $em->getRepository(MainEntityAttribute::class)->findOneBy([
                'code' => $attributeCode,
            ]);
            
            if (!$attribute) {
                throw new \Exception(sprintf("Attribute with code '%s' does not exists", $attributeCode));
            }
            
            if ($attribute->getMultiple()) {
            
            } else {
                $attributeValue = $em->getRepository(MainEntityAttributeValue::class)->findOneBy([
                    'attribute' => $attribute,
                    'product'   => $product,
                ]);
                
                if (!$attributeValue) {
                    $attributeValue = new MainEntityAttributeValue();
                    $attributeValue->setAttribute($attribute)
                        ->setProduct($product)
                        ->setPosition(0);
                    $em->persist($attributeValue);
                }
                
                $attributeValue->setValue($value);
                
                $toDetachs[] = $attributeValue;
            }
            $toDetachs[] = $attribute;
        }
        
        $em->flush();
        
        foreach ($toDetachs as $toDetach) {
            $em->detach($toDetach);
        }
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param                        $productValues
     * @param EntityManagerInterface $em
     *
     * @throws \Exception
     */
    public static function setMultipleProductValues($productValues, EntityManagerInterface $em)
    {
        $toDetachs = [];
        
        foreach ($productValues as $product => $values) {
            
            if (is_int($product)) {
                $product = $em->getRepository(MainEntity::class)->find($product);
            }
            
            foreach ($values as $attributeCode => $value) {
                
                $attribute = $em->getRepository(MainEntityAttribute::class)->findOneBy([
                    'code' => $attributeCode,
                ]);
                
                if (!$attribute) {
                    throw new \Exception(sprintf("Attribute with code '%s' does not exists", $attributeCode));
                }
                
                if ($attribute->getMultiple()) {
                
                } else {
                    $attributeValue = $em->getRepository(MainEntityAttributeValue::class)->findOneBy([
                        'attribute' => $attribute,
                        'product'   => $product,
                    ]);
                    
                    if (!$attributeValue) {
                        $attributeValue = new MainEntityAttributeValue();
                        $attributeValue->setAttribute($attribute)
                            ->setProduct($product)
                            ->setPosition(0);
                        $em->persist($attributeValue);
                    }
                    
                    $attributeValue->setValue($value);
                    
                    $toDetachs[] = $attributeValue;
                }
                $toDetachs[] = $attribute;
            }
            $toDetachs[] = $product;
        }
        
        $em->flush();
        
        foreach ($toDetachs as $toDetach) {
            $em->detach($toDetach);
        }
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param                        $attributeCode
     * @param QueryBuilder           $qb
     * @param EntityManagerInterface $em
     *
     * @return QueryBuilder
     * @throws \Exception
     */
    public static function joinAttribute($attributeCode, QueryBuilder $qb, EntityManagerInterface $em)
    {
        if (!in_array($attributeCode, $qb->getAllAliases())) {
            
            $attribute = $em->getRepository(MainEntityAttribute::class)->findOneBy([
                'code' => $attributeCode,
            ]);
            
            if (!$attribute) {
                throw new \Exception(sprintf("Attribute with code '%s' does not exists", $attributeCode));
            }
            
            $qb
                ->leftJoin('global_product.attributeValues', $attributeCode)
                ->andWhere($attributeCode . '.attribute = :' . $attributeCode . '_attribute')
                ->setParameter($attributeCode . '_attribute', $attribute);
        }
        
        return $qb;
        
    }
}