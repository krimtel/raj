<style>
.emandi-select select{width:210px;float:left;margin-right:10px;}
.emandi-list{margin-top:20px;padding:10px;}
.emandi-list table th{background-color:#70b32d;color:#fff;font-family:'Roboto', sans-serif;}
.e-commodity-list{float:left;}
.commodity-img{float:left;}
.commodity-img span{text-align:center;float:left;width:100%;}

.e-commodity-list img{width:100px;height:100px;margin-right:10px;margin-bottom:5px;margin-top:5px;border:1px solid #ddd;float:left;}
</style>
 <section class="title-header-bg">
	<div class="text-center">
		<h3><?php echo $title; ?></h3>
		<div class="bredcrum-list">
			<ul>
				<li><a href="<?php echo base_url(); ?>" title=""><img style="margin-top:-6px;" alt="" src="<?php echo base_url(); ?>assest/images/home-ico.png" /></a> / </li>
				<li><a href="" title="">NAM</a> / </li>
				<li><a href="" title=""><?php echo $title; ?></a></li>
			</ul>
		</div>
	</div>
</section>
<section class="content-section" style="background-color:#fff;padding:20px 0;float:left;width:100%;">
	<div class="container-fuild" style="padding-left:4%;padding-right:4%;">
		<div class="row">
			<div class="col-md-12 emandi-select">
				<select class="form-control">
					<option>Select State</option>
					<option>Durg</option>
				</select>
				<select class="form-control">
					<option>Select District</option>
					<option>Durg</option>
				</select>
				<select class="form-control">
					<option>Select Mandis</option>
					<option>Durg</option>
				</select>
				<select class="form-control">
					<option>Select Commodity</option>
					<option>Durg</option>
				</select>
				<button class="btn primary-info">
					Search
				</button>
			</div>
			<div class="col-md-12 emandi-list">
				<table class="table table-striped table-bordered">
					<thead><tr><th>State</th><th>District</th><th>Mandis</th><th>Address</th><th>Commodity</th><th>Action</th></tr></thead>
					<tbody>
						<tr role="tab" id="headingOne"><td>CG</td><td>Durg</td><td>Durg</td><td>Gangpara Durg</td><td>Bean</td><td><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-plus"></i></a></td></tr>
						<tr id="collapseOne" role="tabpanel" aria-labelledby="headingOne" class="panel-collapse collapse">
						<td colspan="6" ><div class="e-commodity-list"><div class="commodity-img"><img alt="" src="" /><br><span>Beans</span></div></div></td>
						</tr>
						<tr role="tab" id="headingTwo"><td>CG</td><td>Durg</td><td>Durg</td><td>Gangpara Durg</td><td>Bean</td><td><a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-plus"></i></a></td></tr>
						<tr id="collapseTwo" role="tabpanel" aria-labelledby="headingTwo" class="panel-collapse collapse">
						<td colspan="6" ><div class="e-commodity-list"><div class="commodity-img"><img alt="" src="" /><br><span>Beans</span></div></div></td>
						</tr>
					</tbody>
				</table>
				<!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>-->
	

			</div>
		</div>
	</div>
</section>

