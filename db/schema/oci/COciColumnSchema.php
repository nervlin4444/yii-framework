<?php
/**
 * COciColumnSchema class file.
 *
 * @author Ricardo Grana <rickgrana@yahoo.com.br>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * COciColumnSchema class describes the column meta data of a Oracle table.
 *
 * @author Ricardo Grana <rickgrana@yahoo.com.br>
 * @version $Id: COciColumnSchema.php 1826 2010-02-20 00:40:28Z qiang.xue $
 * @package system.db.schema.oci
 * @since 1.0.5
 */
class COciColumnSchema extends CDbColumnSchema
{
	/**
	 * Extracts the PHP type from DB type.
	 * @param string DB type
	 */
	protected function extractOraType($dbType){
		if(strpos($dbType,'FLOAT')!==false) return 'double';

		if (strpos($dbType,'NUMBER')!==false || strpos($dbType,'INTEGER')!==false)
		{
			if(strpos($dbType,'(') && preg_match('/\((.*)\)/',$dbType,$matches))
			{
				$values=explode(',',$matches[1]);
				if(isset($values[1]) and (((int)$values[1]) > 0))
					return 'double';
				else
					return 'integer';
			}
			else
				return 'double';
		}
		else
			return 'string';
	}

	protected function extractType($dbType)
	{
		$this->type=$this->extractOraType($dbType);
	}

	protected function extractDefault($defaultValue)
	{
		if(stripos($defaultValue,'timestamp')!==false)
			$this->defaultValue=null;
		else
			parent::extractDefault($defaultValue);
	}
}
