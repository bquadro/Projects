<?
//Материалы
$HLB_MATERIAL = 2;

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

$hlblock = HL\HighloadBlockTable::getById($HLB_MATERIAL)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$main_query = new Entity\Query($entity);
$main_query->setSelect(array('*'));
$result = $main_query->exec();
$result = new CDBResult($result);

// build results
$rows = array();
$tableColumns = array();

while ($row = $result->Fetch()){
		$row["ICO"] = CFile::GetByID($row["UF_FILE"]);
		$rows[$row["UF_XML_ID"]] = $row;
}

$arResult["MATERIAL"] = $rows;