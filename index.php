<?php
// auto loader
spl_autoload_register(function ($class) {

	require_once(str_replace('\\', '/', $class . '.php'));
   
});

// Inicia a paginação com o sql
$pag = new \biblioteca\Paginator("select * from estados");

// seta o limit que vai exibir na tabela
$limit = ( @$_GET["limit"]!="" ) ? @$_GET["limit"] : 10;
$page = (  @$_GET["page"]!="" ) ? @$_GET["page"] : 1;
$links  = (  @$_GET["links"]!="") ? @$_GET["links"] : 7;

// Pega os dados. O select vai concatenar com o limit
$rs = $pag->getData($limit,$page,"select * from estados");

if(!empty($rs)){?>
<table>
	<tr>
		<th>Nome</th>
		<th>uf</th>
	</tr>
<?php
	foreach($rs as $chave => $valor){
  
  ?>
	<tr>
	  <td><?php echo $valor->nome; ?></td>
	  <td><?php echo $valor->uf; ?></td>
	</tr>
<?php 
	}
} 
?>
	</table>
<?php
echo $pag->createLinks( $links, 'pagination pagination-sm' );
?>
