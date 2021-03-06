<?php 
use lithium\util\String;
use app\models\Trades;
$virtuals = array('BTC');
$virtualcurrencies = Trades::find('all',array(
	'conditions'=>array('SecondType'=>'Virtual')
));
foreach($virtualcurrencies as $VC){
	array_push($virtuals,substr($VC['trade'],4,3));
}

?>
<table class="table table-condensed table-bordered table-hover" >
	<thead>
	<tr>
			<th>Username</th>
			<th>Full Name</th>			
			<th>Email</th>						
			<th>Sign in</th>
			<th>IP</th>
			<th>Last Login</th>
	</tr>			
	</thead>
	<tbody>
<?php foreach($user as $ur){?>	
	<tr>
		<td><?=$ur['username']?></a></td>
		<td><?=$ur['firstname']?> <?=$ur['lastname']?></td>		
		<td><?=$ur['email']?></td>				
		<td><?=gmdate('Y-M-d H:i:s',$ur['created']->sec)?></td>
		<td><a href="http://whatismyipaddress.com/ip/<?=$ur['ip']?>" target="_blank"><?=$ur['ip']?></a></td>
		<td><a href="http://whatismyipaddress.com/ip/<?=$logins['IP']?>" target="_blank"><?=$logins['IP']?></a> (<?=$loginCount?>)
			<br><?=gmdate('Y-M-d H:i:s',$logins['DateTime']->sec)?></td>
	</tr>
<?php  }?>
	<tr>
		<th style="text-align:center ">BTC</th>
		<th style="text-align:center ">XGC</th>		
		<th style="text-align:center ">USD</th>
		<th style="text-align:center ">GBP</th>
		<th style="text-align:center ">EUR</th>
		<th style="text-align:center ">Email</th>
	</tr>
<?php foreach($details as $dt){?>
	<tr>
		<td style="text-align:center "><?=number_format($dt['balance.BTC'],8)?></td>
		<td style="text-align:center "><?=number_format($dt['balance.XGC'],8)?></td>		
		<td style="text-align:center "><?=number_format($dt['balance.USD'],4)?></td>
		<td style="text-align:center "><?=number_format($dt['balance.GBP'],4)?></td>
		<td style="text-align:center "><?=number_format($dt['balance.EUR'],4)?></td>
		<td style="text-align:center "><?=$dt['email.verified']?></td>
	</tr>
<?php  }?>
	<tr>
		<th style="text-align:center ">Account name</th>
		<th style="text-align:center ">Sort code<br>Company name</th>
		<th style="text-align:center ">Account number<br>Company number</th>
		<th style="text-align:center ">Bank name</th>
		<th style="text-align:center ">Bank address</th>
		<th style="text-align:center">Mobile</td>
	</tr>
<?php foreach($details as $dt){?>
	<tr>
		<td style="text-align:center "><strong>Personal:</strong><br><?=$dt['bank.accountname']?></td>
		<td style="text-align:center "><?=$dt['bank.sortcode']?></td>
		<td style="text-align:center "><?=$dt['bank.accountnumber']?></td>
		<td style="text-align:center "><?=$dt['bank.bankname']?><br>
			<?=$dt['bank.branchaddress']?></td>
		<td style="text-align:center ">
		<?php if($dt['bank.verified']!="Yes"){?>
		<a class="btn btn-primary" href="/Admin/bankapprove/<?=$dt['username']?>">Verify</a>		
		<?php }else{?>
		<span class="label label-success">Verified</span>
		<?php }?>
		</td>				
		<td><?=$dt['mobile.number']?> <?=$dt['mobile.verified']?></td>
	</tr>
	<tr>
		<td style="text-align:center "><strong>Business:</strong><br><?=$dt['bankBuss.accountname']?></td>
		<td style="text-align:center "><?=$dt['bankBuss.sortcode']?><br><?=$dt['bankBuss.companyname']?>
</td>
		<td style="text-align:center "><?=$dt['bankBuss.accountnumber']?><br><?=$dt['bankBuss.companynumber']?></td>
		<td style="text-align:center "><?=$dt['bankBuss.bankname']?><br>
			<?=$dt['bankBuss.branchaddress']?></td>
		<td style="text-align:center ">
		<?php if($dt['bankBuss.verified']!="Yes"){?>
		<a class="btn btn-primary" href="/Admin/bankBussapprove/<?=$dt['username']?>">Verify</a>		
		<?php }else{?>
		<span class="label label-success">Verified</span>
		<?php }?>
		</td>				
		<td><?=$dt['mobile.number']?> <?=$dt['mobile.verified']?></td>
	</tr>
	<tr>
		<th style="text-align:center ">Name</th>
		<th style="text-align:center ">Address</th>
		<th style="text-align:center ">Street</th>
		<th style="text-align:center ">City</th>
		<th style="text-align:center ">Postal Code</th>
		<th style="text-align:center ">Country</th>
	</tr>
	<tr>
		<td style="text-align:center "><?=$dt['postal.Name']?></td>
		<td style="text-align:center "><?=$dt['postal.Address']?></td>
		<td style="text-align:center "><?=$dt['postal.Street']?></td>
		<td style="text-align:center "><?=$dt['postal.City']?></td>
		<td style="text-align:center "><?=$dt['postal.Zip']?></td>				
		<td style="text-align:center "><?=$dt['postal.Country']?></td>

	</tr>
<?php  }
$Amount = 0;
?>
	</tbody>
</table>
<hr>
<div class="row">
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#">Transactions in BTC </a>
			</div>
			<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
			<thead>
				<tr>
					<th>Date</th>
					<th>Amount BTC</th>
					<th>Status</th>
					<th>Paid</th>					
				</tr>
			</thead>
			<tbody>
			<?php foreach ($transactions as $tx){?>
			<tr <?php ?> style="background-color:#669933 "></tr>
				<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
				<td style="text-align:right "><?=number_format($tx['Amount'],8)?></td>
				<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
				<td><?=$tx['Paid']?></td>
			</tr>
			<?php 
			$Amount = $Amount + number_format($tx['Amount'],8);
			} ?>
			<tr>
				<th >Total</th>
				<td style="text-align:right "><?=number_format($Amount,8)?></td>
				<td></td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>

	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#">Transactions in XGC </a>
			</div>
			<table class="table table-condensed table-bordered table-hover"  style="font-size:11px">
			<thead>
				<tr>
					<th>Date</th>
					<th>Amount XGC</th>
					<th>Status</th>
					<th>Paid</th>
				</tr>
			</thead>
			<tbody>
			<?php $Amount = 0;
			foreach ($transactionsXGC as $tx){?>
			<tr <?php ?> style="background-color:#669933 "></tr>
				<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
				<td style="text-align:right "><?=number_format($tx['Amount'],8)?></td>
				<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
				<td><?=$tx['Paid']?></td>
			</tr>
			<?php 
			$Amount = $Amount + number_format($tx['Amount'],8);
			} ?>
			<tr>
				<th >Total</th>
				<td style="text-align:right "><?=number_format($Amount,8)?></td>
				<td></td>
			</tr>
			</tbody>
			</table>
		</div>
	</div>	
	<div class="span3">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#">Transaction in Fiat </a>
			</div>
		<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Currency</th>				
				<th>Type</th>
				<th>Approved</th>				
			</tr>
		</thead>
		<tbody>
<?php 
foreach ($Fiattransactions as $tx){?>
		<tr <?php ?> style="background-color:#669933 "></tr>
			<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
			<td style="text-align:right "><?=number_format($tx['Amount'],2)?></td>
			<td style="text-align:right "><?=$tx['Currency']?></td>			
			<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
			<td style="text-align:center"><?=$tx['Approved']?></td>			

		</tr>
<?php 
} ?>
		</tbody>
	</table>
		</div>
	</div>
</div>
<hr>

<div class="row">	
	<div class="span5">
	<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#">Pending Orders </a>
			</div>
			<table class="table table-condensed table-bordered table-hover"  style="font-size:11px" >
			<thead>
				<tr>
					<th style="text-align:center ">Exchange</th>
					<th style="text-align:center ">Price</th>
					<th style="text-align:center ">Amount</th>
					<th style="text-align:center ">Total</th>					
					<th style="text-align:center ">Commission</th>										
				</tr>
			</thead>
			<tbody>
					<?php foreach($UserOrders as $YO){ ?>
						<tr>
							<td style="text-align:left ">
							<a href="/ex/RemoveOrder/<?=String::hash($YO['_id'])?>/<?=$YO['_id']?>/<?=$sel_curr?>" title="Remove this order">
								<i class="icon-remove"></i></a> &nbsp; 
							<?=$YO['Action']?> <?=$YO['FirstCurrency']?>/<?=$YO['SecondCurrency']?></td>
							<td style="text-align:right "><?=number_format($YO['PerPrice'],5)?>...</td>
							<td style="text-align:right "><?=number_format($YO['Amount'],4)?>...</td>
							<td style="text-align:right "><?=number_format($YO['PerPrice']*$YO['Amount'],4)?>...</td>
							<td style="text-align:right "><?=number_format($YO['Commission.Amount'],4)?> <?=$YO['Commission.Currency']?></td>							
						</tr>
					<?php }?>					
			</tbody>
			</table>
		</div>	
	</div>
	<div class="span5">
		<div class="navbar">
				<div class="navbar-inner">
				<a class="brand" href="#">Completed orders</a>
				</div>
				<div id="YourCompleteOrders" style="height:300px;overflow:auto;">			
			<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
				<thead>
					<tr>
						<th style="text-align:center ">Exchange</th>
						<th style="text-align:center ">Price</th>
						<th style="text-align:center ">Amount</th>
						<th style="text-align:center ">Commission</th>						
					</tr>
				</thead>
				<tbody>
				<?php foreach($UserCompleteOrders as $YO){ ?>
					<tr style="cursor:pointer"
					class=" tooltip-x" rel="tooltip-x" data-placement="top" title="<?=$YO['Action']?> <?=number_format($YO['Amount'],3)?> at 
					<?=number_format($YO['PerPrice'],8)?> on <?=gmdate('Y-m-d H:i:s',$YO['DateTime']->sec)?> from <?=$YO['Transact.username']?>">
						<td style="text-align:left ">
						<?=$YO['Action']?> <?=$YO['FirstCurrency']?>/<?=$YO['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($YO['PerPrice'],4)?>...</td>
						<td style="text-align:right "><?=number_format($YO['Amount'],4)?>...</td>
						<td style="text-align:right "><?=number_format($YO['Commission.Amount'],4)?> <?=$YO['Commission.Currency']?></td>						
					</tr>
				<?php }?>					
				</tbody>
			</table>
				</div>
			</div>	
	
	
	</div>

</div>
<hr>
<div class="row">
	<div class="span11">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#">Reconciliation </a>
			</div>	
			
			
			
		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					<th  class="headTable">Currency</th>
					<?php 
					$currencies = array();
					$trades = Trades::find('all');					
					foreach($trades as $tr){
						$currency = substr($tr['trade'],0,3);
						array_push($currencies,$currency);
						$currency = substr($tr['trade'],4,3);
						array_push($currencies,$currency);
					 }	//for
					$currencies = array_unique($currencies);
					foreach($currencies as $currency){?>
					<th class="headTable" style="text-align:center"><?=$currency?></th>
					<?php }?>
				</tr>
			</thead>
<?php 
if(count($YourOrders['Buy']['result'])>0){
	foreach($YourOrders['Buy']['result'] as $YO){
		$Buy[$YO['_id']['FirstCurrency']] = $Buy[$YO['_id']['FirstCurrency']] + $YO['Amount'];
		$BuyWith[$YO['_id']['SecondCurrency']] = $BuyWith[$YO['_id']['SecondCurrency']] + $YO['TotalAmount'];					
	}
}
if(count($YourOrders['Sell']['result'])>0){
	foreach($YourOrders['Sell']['result'] as $YO){
		$Sell[$YO['_id']['FirstCurrency']] = $Sell[$YO['_id']['FirstCurrency']] + $YO['Amount'];
		$SellWith[$YO['_id']['SecondCurrency']] = $SellWith[$YO['_id']['SecondCurrency']] + $YO['TotalAmount'];					
	}
}
if(count($YourCompleteOrders['Buy']['result'])>0){
	foreach($YourCompleteOrders['Buy']['result'] as $YCO){
		$ComBuy[$YCO['_id']['FirstCurrency']] = $ComBuy[$YCO['_id']['FirstCurrency']] + $YCO['Amount'];
		$ComBuyWith[$YCO['_id']['SecondCurrency']] = $ComBuyWith[$YCO['_id']['SecondCurrency']] + $YCO['TotalAmount'];					
	}
}
if(count($YourCompleteOrders['Sell']['result'])>0){
	foreach($YourCompleteOrders['Sell']['result'] as $YCO){
		$ComSell[$YCO['_id']['FirstCurrency']] = $ComSell[$YCO['_id']['FirstCurrency']] + $YCO['Amount'];
		$ComSellWith[$YCO['_id']['SecondCurrency']] = $ComSellWith[$YCO['_id']['SecondCurrency']] + $YCO['TotalAmount'];					
	}
}
?>			
<?php
foreach($Commissions['result'] as $C){
	foreach($currencies as $currency){
		if($C['_id']['CommissionCurrency']==$currency){
			$variablename = $currency."Comm";
			$$variablename = $C['Commission'];		
		}
	}
}
foreach($CompletedCommissions['result'] as $C){
	foreach($currencies as $currency){
		if($C['_id']['CommissionCurrency']==$currency){
			$variablename = "Completed".$currency."Comm";
			$$variablename = $C['Commission'];		
		}
	}
}
?>
			<tbody>
				<tr>
					<td class="rightTable"><strong>Opening Balance</strong></td>
					<?php foreach($currencies as $currency){
							if(in_array($currency,$virtuals)){
					?>
					<td style="text-align:right"><?=number_format($details['balance.'.$currency]+$Sell[$currency],8)?></td>					
					<?php }else{?>
					<td style="text-align:right"><?=number_format($details['balance.'.$currency]+$Sell[$currency],4)?></td>										
					<?php }}?>					
				</tr>
				<tr>
					<td class="rightTable"><strong>Current Balance</strong><br>
					(including pending orders)</td>
					<?php foreach($currencies as $currency){
						if(in_array($currency,$virtuals)){
					?>
						<td style="text-align:right "><?=number_format($details['balance.'.$currency],8)?></td>
					<?php }else{?>
						<td style="text-align:right "><?=number_format($details['balance.'.$currency],4)?></td>					
					<?php }}?>					
				</tr>
				<tr>
					<td class="rightTable"><strong>Pending Buy Orders</strong></td>
					<?php foreach($currencies as $currency){
						if(in_array($currency,$virtuals)){
						?>
					<td style="text-align:right ">+<?=number_format($Buy[$currency],8)?></td>
					<?php }else{?>
					<td style="text-align:right ">-<?=number_format($BuyWith[$currency],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td class="rightTable"> <strong>Pending Sell Orders</strong></td>
					<?php foreach($currencies as $currency){
						if(in_array($currency,$virtuals)){
						?>
					<td style="text-align:right ">-<?=number_format($Sell[$currency],8)?></td>
					<?php }else{?>
					<td style="text-align:right ">+<?=number_format($SellWith[$currency],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td class="rightTable"><strong>After Execution</strong></td>
					<?php foreach($currencies as $currency){
						if(in_array($currency,$virtuals)){
						$variablename = $currency."Comm";
						
						?>
					<td style="text-align:right "><?=number_format($details['balance.'.$currency]+$Buy[$currency]-$$variablename,8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($details['balance.'.$currency]+$SellWith[$currency]-$$variablename,4)?></td>					
					<?php }
					}?>					
				</tr>
				<tr >
					<td class="rightTable"><strong>Commissions</strong></td>
					<?php foreach($currencies as $currency){
					
						$variablename = $currency."Comm";
						if(in_array($currency,$virtuals)){
						?>
					<td style="text-align:right "><?=number_format($$variablename,8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($$variablename,4)?></td>					
					<?php }}?>					
				</tr>
				<tr>
					<td class="rightTable"><strong>Complete Buy Orders</strong></td>
					<?php foreach($currencies as $currency){
						if(in_array($currency,$virtuals)){
						?>
					<td style="text-align:right "><?=number_format($ComBuy[$currency],8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($ComBuyWith[$currency],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td class="rightTable"><strong>Complete Sell Orders</strong></td>
					<?php foreach($currencies as $currency){
						if(in_array($currency,$virtuals)){
						?>
					<td style="text-align:right "><?=number_format($ComSell[$currency],8)?></td>
					<?php }else{?>
					<td style="text-align:right "><?=number_format($ComSellWith[$currency],4)?></td>										
					<?php }
					}?>					
				</tr>
				<tr>
					<td class="rightTable"><strong>Completed Order Commissions</strong></td>
					<?php foreach($currencies as $currency){
							$variablename = "Completed".$currency."Comm";
							if(in_array($currency,$virtuals)){
						?>
					<td style="text-align:right "><?=number_format($$variablename,8)?></td>
					<?php }else{?>					
					<td style="text-align:right "><?=number_format($$variablename,4)?></td>					
					<?php }}?>										
				</tr>
			</tbody>
		</table>
			
			
			
			
			
		</div>
	</div>
</div>