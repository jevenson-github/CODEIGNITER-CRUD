drop procedure if exists usp_ci_UploadAutofillTaggingFile_SKU;

--
-- Start:       End:        By:     Description:
-- 03/05/15     03/05/15    jpg     Creation
--
create procedure usp_ci_UploadAutofillTaggingFile_SKU
(
    strPathFileName varchar(500),
    intEPeriod int,
    intEYear int
)

BEGIN

declare recordcount int;
declare uniquerecordcount int;
declare recordcount2 int;
declare uniquerecordcount2 int;
declare intPeriodType int;

declare tmpclientcodeid int;



set intPeriodType = 1;

-- DELETE HEADERS and blank data before validating data
delete from tbluploadautofilltaggingfile_sku where SKUID like '%sku%';

drop temporary table if exists temp;
create temporary table temp
(
    SKUID int default 0,
    OfftakeAutofillStatus varchar(10),
    EPeriod int default 0,
    EYear int default 0
);

insert into temp (SKUID, OfftakeAutofillStatus)
select *
from tbluploadautofilltaggingfile_sku;

update temp
    set EYear = intEYear, 
        EPeriod = intEPeriod
where EYear = 0 and EPeriod = 0;

update temp
    set OfftakeAutofillStatus = -1
where OfftakeAutofillStatus is null;

-- =======================================================
drop temporary table if exists temp_validation;
create temporary table temp_validation
(
    SKUID int,
    OfftakeAutofillStatus varchar(10),
    isSKUID tinyint(3) default 0,
    isActive tinyint(3) default 0,
    EPeriod int,
    EYear int
);

insert into temp_validation(SKUID, OfftakeAutofillStatus, EPeriod, EYear)
select  SKUID, OfftakeAutofillStatus, EPeriod, EYear
from    temp;

-- Check if SKUID(s) exists
update temp_validation
    set isSKUID = 1
    where SKUID IN (select SKUID from skus);  

-- Check if SKUID(s) exists
update temp_validation
    set isActive = 1
    where SKUID IN (select SKUID from skus where active = 1);  

-- To check if uploaded file has any bad or invalid data =======================================================
drop temporary table if exists validationTable;
create temporary table validationTable
(
    ErrorCode int default 0, SKUID int null, OfftakeAutofillStatus int null, EPeriod int null, EYear int null
);

-- CHECK UPLOADED FILE =======================================================
if exists(select 1 from temp_validation where isSKUID = 0) then    -- no SKUID
    insert into validationTable(ErrorCode, SKUID)
    select distinct -1, SKUID from temp_validation where isSKUID = 0;
end if;

if exists(select 1 from temp_validation where isActive = 0 and isSKUID = 1) then    -- SKUID is inactive
    insert into validationTable(ErrorCode, SKUID)
    select distinct -2, SKUID from temp_validation where isActive = 0;
end if;

if exists(select 1 from temp_validation where OfftakeAutofillStatus = -1) then -- no OfftakeAutofill Status
    insert into validationTable(ErrorCode, SKUID)
    select distinct -3, SKUID from temp_validation where OfftakeAutofillStatus = -1;
end if;

if exists(select 1 from temp_validation where OfftakeAutofillStatus <> '0' and OfftakeAutofillStatus <> '1' and OfftakeAutofillStatus <> -1) then -- incorrect input for OfftakeAutofill Status
    insert into validationTable(ErrorCode, SKUID)
    select distinct -4, SKUID from temp_validation where OfftakeAutofillStatus <> '0' and OfftakeAutofillStatus <> '1' and OfftakeAutofillStatus <> -1;
end if;

-- =====================================================

if not exists (select * from validationTable) then
    
    truncate tblautofilltagging_sku;
    
    insert into validationTable 
        select distinct 0, SKUID, convert(OfftakeAutofillStatus, signed), EPeriod, EYear
    from temp_validation;

    insert into tblautofilltagging_sku (SKUID, OfftakeAutofillStatus, EPeriod, EYear)
    select  SKUID, convert(OfftakeAutofillStatus, signed), EPeriod, EYear
    from    temp_validation;
    
    
    
end if;
-- ========================================================

select ErrorCode as ErrorCode, SKUID as SKUID, OfftakeAutofillStatus as OfftakeAutofillStatus, EPeriod as EPeriod, EYear as EYear from validationTable;

END;

-- call usp_ci_UploadAutofillTaggingFile ('/data/smsabbott/upload_autofill_tagging_file.csv','9','2015')
