<link href="themes/default/css/front.css" rel="stylesheet" type="text/css" />
<div class="layer layerSize hide" id="addressd">

<h5>使用新收货地址</h5>
<form action="user.php" method="post" name="theForm" onsubmit="return checkConsignee(this)">
  <dl class="newAddress">
    <dt><em>*</em><?php echo $this->_var['lang']['country_province']; ?>：</dt>
    <dd>
        <select name="country" id="selCountries_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 1, 'selProvinces_<?php echo $this->_var['sn']; ?>')">
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['0']; ?></option>
        <?php $_from = $this->_var['country_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'country');if (count($_from)):
    foreach ($_from AS $this->_var['country']):
?>
        <option value="<?php echo $this->_var['country']['region_id']; ?>" <?php if ($this->_var['consignee']['country'] == $this->_var['country']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['country']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <select name="province" id="selProvinces_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 2, 'selCities_<?php echo $this->_var['sn']; ?>')">
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['1']; ?></option>
        <?php $_from = $this->_var['province_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');if (count($_from)):
    foreach ($_from AS $this->_var['province']):
?>
        <option value="<?php echo $this->_var['province']['region_id']; ?>" <?php if ($this->_var['consignee']['province'] == $this->_var['province']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['province']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <select name="city" id="selCities_<?php echo $this->_var['sn']; ?>" onchange="region.changed(this, 3, 'selDistricts_<?php echo $this->_var['sn']; ?>')">
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['2']; ?></option>
        <?php $_from = $this->_var['city_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
        <option value="<?php echo $this->_var['city']['region_id']; ?>" <?php if ($this->_var['consignee']['city'] == $this->_var['city']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['city']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
      <select name="district" id="selDistricts_<?php echo $this->_var['sn']; ?>" <?php if (! $this->_var['district_list'][$this->_var['sn']]): ?>style="display:none"<?php endif; ?>>
        <option value="0"><?php echo $this->_var['lang']['please_select']; ?><?php echo $this->_var['name_of_region']['3']; ?></option>
        <?php $_from = $this->_var['district_list'][$this->_var['sn']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'district');if (count($_from)):
    foreach ($_from AS $this->_var['district']):
?>
        <option value="<?php echo $this->_var['district']['region_id']; ?>" <?php if ($this->_var['consignee']['district'] == $this->_var['district']['region_id']): ?>selected<?php endif; ?>><?php echo $this->_var['district']['region_name']; ?></option>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </select>
    <?php echo $this->_var['lang']['require_field']; ?> 
    </dd>


    <dt><?php echo $this->_var['lang']['consignee_name']; ?>：</dt>
    <dd><input name="consignee" type="text" class="inputBg" id="consignee_0" value="" />
    <?php echo $this->_var['lang']['require_field']; ?> </dd>
    <dt><?php echo $this->_var['lang']['email_address']; ?>：</dt>
    <dd><input name="email" type="text" class="inputBg" id="email_<?php echo $this->_var['sn']; ?>" value="" />
    <?php echo $this->_var['lang']['require_field']; ?></dd>
  
 
    <dt><?php echo $this->_var['lang']['detailed_address']; ?>：</dt>
    <dd><input name="address" type="text" class="inputBg" id="address_<?php echo $this->_var['sn']; ?>" value="" />
    <?php echo $this->_var['lang']['require_field']; ?></dd>
    <dt><?php echo $this->_var['lang']['postalcode']; ?>：</dt>
    <dd><input name="zipcode" type="text" class="inputBg" id="zipcode_<?php echo $this->_var['sn']; ?>" value="" /></dd>
    
   
      <dt><?php echo $this->_var['lang']['phone']; ?>：</dt>
      <dd><input name="tel" type="text" class="inputBg" id="tel_<?php echo $this->_var['sn']; ?>" value="" />
      <?php echo $this->_var['lang']['require_field']; ?></dd>
      <dt"><?php echo $this->_var['lang']['backup_phone']; ?>：</dt>
      <dd><input name="mobile" type="text" class="inputBg" id="mobile_<?php echo $this->_var['sn']; ?>" value="" /></dd>
  
      <dt><?php echo $this->_var['lang']['sign_building']; ?>：</dt>
      <dd><input name="sign_building" type="text" class="inputBg" id="sign_building_<?php echo $this->_var['sn']; ?>" value="" /></dd>
      <dt><?php echo $this->_var['lang']['deliver_goods_time']; ?>：</dt>
      <dd><input name="best_time" type="text"  class="inputBg" id="best_time_<?php echo $this->_var['sn']; ?>" value="" /></dd>
  
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" name="submit" class="bnt_blue_2"  value="<?php echo $this->_var['lang']['add_address']; ?>"/>
        <input type="hidden" name="act" value="act_edit_address" />
        <input name="address_id" type="hidden" value="<?php echo $this->_var['consignee']['address_id']; ?>" />
      </dd>
    
  </dl>
</form>
</div>