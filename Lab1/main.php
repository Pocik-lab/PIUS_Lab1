<?php

require_once 'vendor/autoload.php';

use Symfony\Component\Validator\Validation;
use App\Employee as Employee;
use App\Department as Department;

echo"-----Task 2.1-----\n";
$validator = Validation::createValidatorBuilder()
    ->enableAnnotationMapping()
    ->addDefaultDoctrineAnnotationReader()
    ->getValidator();
echo"\nДемонстрация работы валидатора на полностью неправильном объекте\n\n";
$object1 = new Employee(-1, "", -20, 20);
$errors = $validator->validate($object1);

if (count($errors) > 0) {
    $errorString = (string) $errors;

    echo $errorString;
}
echo"\nДемонстрация работы валидатора на полностью правильном объекте\n\n";
$object2 = new Employee(1, "Александр", 2000, "2020-01-01");
echo $object2->getExperience();
$errors = $validator->validate($object2);

if (count($errors) > 0) {
    $errorString = (string) $errors;

    echo $errorString;
}

echo"\n-----Task 2.2-----\n";
$departmentArray = array();
$departNames = array("Miet", "Yandex", "Sber", "VTB", "Apple", "Google");

for ($i = 0; $i < 3; $i++) {
    $tmpEmployArr = array();
    for ($j = 0; $j < rand(2, 6); $j++) {
        array_push($tmpEmployArr, new Employee($j, "Alex", rand(1, 2), "2005/01/01"));
    }
    $tmpDepartment = new Department($tmpEmployArr, $departNames[rand(0, count($departNames) - 1)]);
    array_push($departmentArray, $tmpDepartment);
}

$minSalary = 10000000000;
$maxSalary = -1;

foreach ($departmentArray as $depart) {
    $tmpSum = $depart->getEmploySumSalary();
    echo "Sum of department - ".$depart->getName()." = ".$tmpSum."\n";
    if ($tmpSum <= $minSalary) {
        $minSalary = $tmpSum;
    }
    if ($tmpSum >= $maxSalary) {
        $maxSalary = $tmpSum;
    }
}

$depMinSal = array();
$depMaxSal = array();

foreach ($departmentArray as $depart) {
    $salSum = $depart->getEmploySumSalary();
    if ($salSum == $minSalary) {
        array_push($depMinSal, $depart);
    }
    if ($salSum == $maxSalary) {
        array_push($depMaxSal, $depart);
    }
}

if (count($depMinSal) == 1) {
    echo 'Департамент с самой маленькой суммой зарплат работников = '.$minSalary.' - '.$depMinSal[0]->getName()."\n";
}
if (count($depMaxSal) == 1) {
    echo 'Департамент с самой большой суммой зарплат работников = '.$maxSalary.' - '.$depMaxSal[0]->getName()."\n";
}

if (count($depMinSal) > 1) {
    $maxId = -1;
    for ($i = 0; $i < count($depMinSal); $i++) {
        for ($j = $i; $j < count($depMinSal); $j++) {
            if (count($depMinSal[$i]->getEmployArr()) > count($depMinSal[$j]->getEmployArr())) {
                $maxId = $i;
            } elseif (count($depMinSal[$i]->getEmployArr()) < count($depMinSal[$j]->getEmployArr())) {
                $maxId = $j;
            }
        }
    }
    if ($maxId != -1) {
        echo'Департамент с наим. суммой зарплаты = '.$minSalary.' ,но большим кол-вом сотрудников = '.count($depMinSal[$maxId]->getEmployArr()).' - '.$depMinSal[$maxId]->getName()."\n";
    } else {
        foreach ($depMinSal as $depart) {
            echo 'Департамент с наим. суммой зарплаты = '.$minSalary.' и равным кол-вом сотрудников =  '.count($depart->getEmployArr()).' - '.$depart->getName()."\n";
        }
    }
}

if (count($depMaxSal) > 1) {
    $maxId = -1;
    for ($i = 0; $i < count($depMaxSal); $i++) {
        for ($j = $i; $j < count($depMaxSal); $j++) {
            if (count($depMaxSal[$i]->getEmployArr()) > count($depMaxSal[$j]->getEmployArr())) {
                $maxId = $i;
            } elseif (count($depMaxSal[$i]->getEmployArr()) > count($depMaxSal[$j]->getEmployArr())) {
                $maxId = $j;
            }
        }
    }
    if ($maxId != -1) {
        echo'Департамент с наиб. суммой зарплаты = '.$maxSalary.', но наиб. кол-вом сотрудников = '.count($depMaxSal[$maxId]->getEmployArr()).' - '.$depMaxSal[$maxId]->getName()."\n";
    } else {
        foreach ($depMaxSal as $depart) {
            echo 'Департамент с наиб. суммой зарплаты = '.$maxSalary.' и равным кол-вом сотрудников =  '.count($depart->getEmployArr()).' - '.$depart->getName()."\n";
        }
    }
}
