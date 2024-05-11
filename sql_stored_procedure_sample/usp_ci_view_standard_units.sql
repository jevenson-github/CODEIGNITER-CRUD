DROP PROCEDURE `usp_ci_view_standard_units`

GO
--MySQL Stored Procedure with Parameters
--The procedure takes one input parameter, intSUID,
CREATE PROCEDURE `usp_ci_view_standard_units`( intSUID int )

BEGIN

--Declairing Variables  
declare intUnitType int;

--Inside the procedure, a temporary table named tmp_final is created. 
--This table is used to store intermediate results and the final output of the procedure.
CREATE temporary TABLE tmp_final (row_type int default 0, su_id varchar(10) default '', su_name varchar(100) default '', su_abbrev varchar(10) default '', su_unit_type varchar(10) default '', su_view varchar(100) default '', start_u varchar(100) default '', final_u varchar(100) default '', convrtd_u varchar(100) default '');



--The procedure first inserts information about the standard unit with the specified SUID into the tmp_final table. 
INSERT INTO tmp_final (row_type, su_id, su_name, su_abbrev, su_unit_type, su_view)
SELECT  '0'
       ,SUID
       ,SUName
       ,SUAbbrev
       ,UnitType
       ,SUView
FROM standardunits
WHERE SUID = intSUID;

--It also selects the UnitType of the specified unit and stores it in the variable intUnitType.
select UnitType into intUnitType from standardunits where SUID = intSUID;


--The first query (with row_type '1') retrieves metric conversion data from the metrictable and standardunits tables based on 
--matching UnitType values. 
--It selects fields such as su_id, su_unit_type, start_u, final_u, and convrtd_u.
INSERT INTO tmp_final (row_type, su_id, su_unit_type, start_u, final_u, convrtd_u)
SELECT  Distinct '1'
       ,a.SUID
       ,a.UnitType
       ,a.Metric
       ,c.SUName
       ,a.Value AS Conv1
FROM metrictable a
LEFT JOIN standardunits b
ON a.SUID = b.SUID
LEFT JOIN standardunits c
ON a.UnitType = c.UnitType
WHERE b.UnitType = intUnitType;

--The second query (with row_type '2') retrieves metric conversion data from the metrictable table based on a matching SUID. 
--It also selects fields such as su_id, su_unit_type, start_u, final_u, and convrtd_u.
INSERT INTO tmp_final (row_type, su_id, su_unit_type, start_u, final_u, convrtd_u)
SELECT  Distinct '2'
       ,a.SUID
       ,a.UnitType
       ,a.Metric
       ,b.SUName
       ,a.Value AS Conv2
FROM metrictable a
LEFT JOIN standardunits b
ON a.UnitType = b.UnitType
WHERE b.SUID = intSUID;

--After inserting data into the tmp_final table, 
--the procedure performs a SELECT * query on tmp_final, which returns the collected data as the final output of the procedure.
select * from tmp_final;


--Finally, the procedure drops the temporary table tmp_final to clean up temporary storage used during the procedure execution.
drop temporary table tmp_final;

END