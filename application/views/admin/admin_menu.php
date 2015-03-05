<style>
.admin-menu a {
padding-top: 1px;
padding-left: 5PX;
padding-right: 5px;
padding-bottom: 0px;
font-size: 11px;
letter-spacing: 1px;
border-bottom-left-radius: 0px;
border-bottom-right-radius: 0px;
margin-bottom:-40px;
}
a:hover { background:gold; color:#fff; } 

</style>
<div class="admin-menu">
	<a <?php echo !empty($menu_account) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/account">MY ACCOUNT</a>
	<a <?php echo !empty($menu_settings) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/settings">MY SETTINGS</a>
    <a <?php echo !empty($menu_products) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/products">MY PRODUCTS</a>
    <a <?php echo !empty($menu_listings) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/listings">MY LISTINGS</a>
    <a <?php echo !empty($menu_purchases) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/account">MY PURCHASES</a>
    <a <?php echo !empty($menu_sales) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/sales">MY SALES</a>
    <a <?php echo !empty($menu_sales) ? 'style="background:#006989;"' : ''; ?> class="btn btn-default" href="/admin/store">MY STORE</a>
</div>