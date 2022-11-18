<?php
header('Content-Type: text/html; charset = utf-8');
error_reporting(E_ALL);
mb_internal_encoding("UTF-8");

//вывод уведомлений
function send_notice($msg, $param = 0) {
  if ($param == 1) {
    $show = '<div class="message-green"><span class="message-text">'.$msg.'</span></div>';//зеленый фон. успешн.
  }
  else {
    $show = '<div class="message-red"><span class="message-text">'.$msg.'</span></div>';//красный фон. ошибка
  }

  echo $show.'<br>';
}
//

$pay = '';
if(isset($_POST['submit'])){
    $salary = $_POST['wage']; //желаемая зарплата работника
    if (isset($_POST['ndfl_check'])) {
      $ndfl = $salary*13/100; //НДФЛ на физ. лицо
    }
    else $ndfl = 0;
    if (isset($_POST['medical_insurance_check'])) {
      $medical_insurance = $salary*5.1/100; //медстраховка
    }
    else $medical_insurance = 0;
    if (isset($_POST['ndfl_entity_check'])) {
      $ndfl_entity = $salary*6/100; //НДФЛ на юр.лицо
    }
    else $ndfl_entity = 0;
    if (isset($_POST['pfr_check'])) {
      $pfr = $salary*22/100; //налог в ПФР
    }
    else $pfr = 0;
    if (isset($_POST['social_insurance_check'])) {
      $social_insurance = $salary*2.9/100; //соц. страховка
    }
    else $social_insurance = 0;
    if (isset($_POST['company_profit_check'])) {
      $company_profit = ($salary+$ndfl+$medical_insurance+$ndfl_entity+$pfr+$social_insurance)*10/100; //прибыль компании
    }
    else $company_profit = 0;
    if (isset($_POST['office_rent_check'])) {
      $office_rent = $company_profit*$_POST['office_rent']/100; //аренда офиса
    }
    else $office_rent = 0;
    if (isset($_POST['management_salary_check'])) {
      $management_salary = $company_profit*$_POST['management_salary']/100; //зарплата руководства
    }
    else $management_salary = 0;
    if (isset($_POST['depreciation_check'])) {
      $depreciation = $company_profit*$_POST['depreciation']/100; //амортизация оборуд., техника
    }
    else $depreciation = 0;
    if (isset($_POST['accounting_department_check'])) {
      $accounting_department = $company_profit*$_POST['accounting_department']/100; //расходы на бухгалтерию
    }
    else $accounting_department = 0;
    if (isset($_POST['marketing_check'])) {
      $marketing = $company_profit*$_POST['marketing']/100; //расходы на маркетинг, продажи
    }
    else $marketing = 0;
    
    $pay = round ((($salary + $ndfl + $medical_insurance + $ndfl_entity + $pfr + $social_insurance + $company_profit + 
        $office_rent + $management_salary + $depreciation + $accounting_department + $marketing)/20/8), 1, PHP_ROUND_HALF_UP);
    $message = 'Стоимость часа работы: '.$pay.' руб/час.';
    if ($management_salary == 0) {
      $message .= '<br>Внимание! Вы отключили пункт "Зарплата руководства". Будьте осторожны, им это не понравится...';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вопросы</title>
  <style>
    /*стили функции вывода уведомлений*/
.message-green{
  display: flex;
  text-align: center;
  width: 600px;
  background: #D4E5D0;
  border-radius: 5px;
  border: 1px solid #52B231;
  padding: 15px;
}
.message-red{
  display: flex;
  width: 600px;
  background: #FAEAEA;
  border-radius: 5px;
  border: 1px solid #DD4F43;
  padding: 15px;
}
.message-text{
  color: black;
  margin: auto;
}
.wrap{
  display: flex;
  flex-direction: column;
  align-items: center;
}
.btn{
  margin-top: 20px;
  background: #A7C0DC;
  width: 200px;
  height: 30px;
  border: solid #498AF4 1px;
  border-radius: 4px;
  cursor: pointer;
}
.btn:hover{
  background: #8DA2B9;
}
/*стили функции вывода уведомлений*/
.group1{
  margin: 0;
visibility: hidden;
}

</style>
</head>
<body>
<div class="wrap">

<h3>Расчет стоимости часа работы</h3>
<form  method="POST">
Желаемая з/п:<br><input type="number" name="wage" id="a" value="60000"><br>
Количество рабочих дней (в месяце):<br><input type="number" name="days" id="b" value="20"><br>
Количество рабочих часов (в день):<br><input type="number" name="hours" id="c" value="8"><br>
НДФЛ 13%:<br><input type="number" name="ndfl" value="13">
<input type="checkbox" name="ndfl_check" checked>учитывать
<br>
Медстраховка 5,1%:<br><input type="text" name="medical_insurance" id="e" value="5.1" step="any">
<input type="checkbox" name="medical_insurance_check" checked>учитывать
<br>
НДФЛ юр.лиц 6%:<br><input type="number" name="ndfl_entity" id="f" value="6">
<input type="checkbox" name="ndfl_entity_check" checked>учитывать
<br>
В ПФР 22%:<br><input type="number" name="pfr" id="g" value="22">
<input type="checkbox" name="pfr_check"  checked>учитывать
<br>
Соц. страховка 2,9%:<br><input type="text" name="social_insurance" id="h" value="2.9" step="any">
<input type="checkbox" name="social_insurance_check"  checked>учитывать
<br>
Прибыль компании 10%:<br><input type="number" name="company_profit" id="i" value="10">
<input type="checkbox" name="company_profit_check" checked>учитывать
<br>
Аренда офиса и проч., %:<br><input type="number" name="office_rent" id="j" value="10">
<input type="checkbox" name="office_rent_check" checked>учитывать
<br>
З/плата руководства, %:<br><input type="number" name="management_salary" id="k" value="10">
<input type="checkbox" name="management_salary_check" checked>учитывать
<br>
Амортизация оборуд., техника, %:<br><input type="number" name="depreciation" id="l" value="10">
<input type="checkbox" name="depreciation_check" checked>учитывать
<br>
Расходы на бухгалтерию, %:<br><input type="number" name="accounting_department" id="m" value="10">
<input type="checkbox" name="accounting_department_check" checked>учитывать
<br>
Расходы на маркетинг и продажи, %:<br><input type="number" name="marketing" id="n" value="15">
<input type="checkbox" name="marketing_check" checked>учитывать
<br><br>

<input type="submit" name="submit" value="Рассчитать" class="btn"><br>
</form><br>

<?php 
if(isset($message)) {
  send_notice($message, $param = 1); 
}
?>

</div>
</body>
</html>
