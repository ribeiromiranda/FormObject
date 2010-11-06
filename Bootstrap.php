<?php
/*
 * This file is part of FormObject.
 *
 * Foobar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Foobar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @package FormObject
 * @author André Ribeiro de Miranda <ardemiranda@gmail.com>
 * @copyright 2010 André Ribeiro de Miranda
 * 
 * @license http://www.gnu.org/copyleft/lesser.txt GNU LESSER GENERAL PUBLIC LICENSE
 * @link http://belocodigo.com.br
 */

error_reporting( E_ALL | E_STRICT );

$coreLibrary = __DIR__ . '/library';
$coreTests   = __DIR__ . '/tests';
$pathSqlite  = __DIR__ . '/data/db.sqlite';

set_include_path(implode(PATH_SEPARATOR, 
	array(
		__DIR__,
		$coreLibrary,
		$coreTests,
		__DIR__ . '/demos',
		get_include_path()
)));

require "{$coreLibrary}/Zend/Loader.php";

spl_autoload_register(function ($class) {
	Zend_Loader::loadClass($class);
});

if (file_exists($pathSqlite) && !is_writable($pathSqlite)) { 
	throw new Exception("Não tem permissão de escrita na pasta {$pathSqlite}");
}


$config = new \Doctrine\ORM\Configuration;
$cache  = new \Doctrine\Common\Cache\ApcCache;
//$config->setMetadataCacheImpl($cache);
$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . '/Models');
$config->setMetadataDriverImpl($driverImpl);
//$config->setQueryCacheImpl($cache);
$config->setProxyDir(realpath(__DIR__ . '/data/Proxies'));
$config->setProxyNamespace('FormObject\Proxies');
$config->setAutoGenerateProxyClasses(true);


$em = \Doctrine\ORM\EntityManager::create(array(
	'driver'   => 'pdo_sqlite',
	'path'		   => __DIR__ . '/data/db.sqlite'
), $config);

$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = array();
foreach ($driverImpl->getAllClassNames() as $class) {
	$classes[] = $em->getClassMetadata($class);
}

$tool->dropSchema($classes);
$tool->createSchema($classes);


\FormObject\Form::setEntityManager($em);
\Zend_Registry::set('view', new Zend_View());
\Zend_Registry::set('em', $em);


unset($coreLibrary, $coreTests);
