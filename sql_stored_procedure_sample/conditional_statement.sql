DROP PROCEDURE `usp_ci_update_sms_defaults`

GO

CREATE  PROCEDURE `usp_ci_update_sms_defaults`(
	sms_key_value varchar(100),                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
	int_value varchar(50),
	varchar_value varchar(100),
	float_value varchar(50),
	txt_changed int,
	int_operation int
)
BEGIN 

declare int_return int;
declare sms_key varchar(100);
Set int_return = 0;

--first block of statement 
if int_operation = 1 then -- add
	if exists (select SMSKey from smsdefaults where SMSKey = sms_key_value) then	
		set int_return = -1;
		set sms_key = sms_key_value;	
	else	
		set sms_key = sms_key_value;
			if varchar_value = '' then		
				if ((float_value = '') and (fn_ci_IsNumeric(int_value) = 1)) then
					-- select 'decimal is null'
					insert into smsdefaults(SMSkey, SMSValueInt)
					select sms_key_value, cast(int_value as signed);
				elseif int_value = '' and fn_ci_IsNumeric(float_value) = 1 then
					-- select 'int is null'
					insert into smsdefaults(SMSkey, SMSValueFloat)
					select sms_key_value, cast(float_value as decimal);
				elseif int_value = '' and float_value = '' then
					-- select 'decimal and int is null'
					insert into smsdefaults(SMSkey)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
					select sms_key_value;
				else
					-- select 'no nulls'
					insert into smsdefaults(SMSkey, SMSValueInt, SMSValueFloat)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
					select sms_key_value, cast(int_value as signed), cast(float_value as decimal);
				end if;
		else 
				if float_value = '' and fn_ci_IsNumeric(int_value) = 1 then			
					-- select 'decimal is null'
					insert into smsdefaults(SMSkey, SMSValueInt, SMSValueVarchar)
					select sms_key_value, cast(int_value as signed), varchar_value;
				elseif int_value = '' and fn_ci_IsNumeric(float_value) = 1 then
					-- select 'int is null'
					insert into smsdefaults(SMSkey, SMSValueVarchar, SMSValueFloat)
					select sms_key_value, varchar_value, cast(float_value as decimal);
				elseif int_value = '' and float_value = '' then
					-- select 'decimal and int is null'
					insert into smsdefaults(SMSkey, SMSValueVarchar)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
					select sms_key_value, varchar_value;
				else
					-- select 'no nulls'
					insert into smsdefaults(SMSkey, SMSValueInt, SMSValueVarchar, SMSValueFloat)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
					select sms_key_value, cast(int_value as signed), varchar_value, cast(float_value as decimal);	
				end if;			
	end if;
end if;

 --second block of statement 
 else if int_operation = 2 then -- edit
	if txt_changed = 1 then
		update smsdefaults 
		set SMSValueInt = cast(int_value as signed),
		    SMSValueVarchar = varchar_value, 
		    SMSValueFloat = cast(float_value as decimal)
		where SMSKey = sms_key_value;
	end if;
	set int_return = 0;
	set sms_key = sms_key_value;
end if;

Select int_return as returned_value, sms_key as returned_name;

END