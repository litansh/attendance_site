/*
Connect MySQL to SQL db, Convert MySQL table to SQL, Move MySQL table 'dbo.attend' to SQL general 'tables'.
*/

USE micro_data
GO
 IF NOT EXISTS(SELECT * FROM sys.schemas WHERE [name] = N'clockin')      
  EXEC (N'CREATE SCHEMA clockin')                                   
 GO                                                               

USE micro_data
GO
IF EXISTS (SELECT * FROM sys.objects so JOIN sys.schemas sc ON so.schema_id = sc.schema_id WHERE so.name = N'attend'  AND sc.name = N'clockin'  AND type in (N'U'))
BEGIN
 DECLARE @drop_statement nvarchar(500)
  DECLARE drop_cursor CURSOR FOR
   SELECT 'alter table '+quotename(schema_name(ob.schema_id))+
    '.'+quotename(object_name(ob.object_id))+ ' drop constraint ' + quotename(fk.name) 
    FROM sys.objects ob INNER JOIN sys.foreign_keys fk ON fk.parent_object_id = ob.object_id
    WHERE fk.referenced_object_id = 
     (
      SELECT so.object_id 
      FROM sys.objects so JOIN sys.schemas sc
      ON so.schema_id = sc.schema_id
      WHERE so.name = N'attend'  AND sc.name = N'clockin'  AND type in (N'U')
     )

OPEN drop_cursor
 FETCH NEXT FROM drop_cursor
 INTO @drop_statement
 WHILE @@FETCH_STATUS = 0
  BEGIN
   EXEC (@drop_statement)
   FETCH NEXT FROM drop_cursor
   INTO @drop_statement
  END
  CLOSE drop_cursor
 DEALLOCATE drop_cursor
 DROP TABLE [clockin].[attend]
END 
GO


SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE 
[clockin].[attend]
 (
  [id] int IDENTITY(7, 1)  NOT NULL,
  [Terminal_ID] int  NOT NULL,
  [Badge_ID] varchar(50)  NOT NULL,
  [Rec_Date] varchar(250)  NOT NULL,
  [Rec_Time] varchar(250)  NOT NULL,
  [Type_InOut] varchar(50)  NOT NULL
)
WITH (DATA_COMPRESSION = NONE)
GO
BEGIN TRY
    EXEC sp_addextendedproperty
        N'MS_SSMA_SOURCE', N'clockin.attend',
        N'SCHEMA', N'clockin',
        N'TABLE', N'attend'
END TRY
BEGIN CATCH
    IF (@@TRANCOUNT > 0) ROLLBACK
    PRINT ERROR_MESSAGE()
END CATCH
GO


USE micro_data
GO
IF EXISTS (SELECT * FROM sys.objects so JOIN sys.schemas sc ON so.schema_id = sc.schema_id WHERE so.name = N'PK_attend_id'  AND sc.name = N'clockin'  AND type in (N'PK'))
ALTER TABLE [clockin].[attend] DROP CONSTRAINT [PK_attend_id]
GO

ALTER TABLE [clockin].[attend]
 ADD CONSTRAINT [PK_attend_id]
  PRIMARY KEY
  CLUSTERED ([id] ASC)
GO


/*
Unite table 'dbo.attend' to 'table dbo.ReadRecords' rows if date is the current in MySQL.
*/

DECLARE @Rec_Date_Current VARCHAR(100)
DECLARE @YEAR VARCHAR(100)
DECLARE @MONTH VARCHAR(100)
DECLARE @DAY VARCHAR(100)

SET @Rec_Date_Current = GETDATE();

SET @YEAR = SUBSTRING(@Rec_Date_Current,7, CHARINDEX(' ',@Rec_Date_Current))
SET @MONTH = SUBSTRING(@Rec_Date_Current,0, CHARINDEX(' ',@Rec_Date_Current))
SET @DAY = SUBSTRING(@Rec_Date_Current,4, CHARINDEX(' ',@Rec_Date_Current))

DECLARE @MYSQLMONTH VARCHAR(100);
DECLARE @MYSQLYEAR VARCHAR(100);
DECLARE @MYSQLDAY VARCHAR(100);

SET @MYSQLYEAR = @YEAR;
SET @MYSQLDAY = @DAY;

IF ( @MONTH = 'Jan' )
BEGIN
 SET @MYSQLMONTH = '01';
END
ELSE IF ( @MONTH = 'Feb' )
BEGIN
 SET @MYSQLMONTH = '02';
END
ELSE IF ( @MONTH = 'Mar' )
BEGIN
 SET @MYSQLMONTH = '03';
END
ELSE IF ( @MONTH = 'Apr' )
BEGIN
 SET @MYSQLMONTH = '04';
END
ELSE IF ( @MONTH = 'May' )
BEGIN
 SET @MYSQLMONTH = '05';
END
ELSE IF ( @MONTH = 'Jun' )
BEGIN
 SET @MYSQLMONTH = '06';
END
ELSE IF ( @MONTH = 'Jul' )
BEGIN
 SET @MYSQLMONTH = '07';
END
ELSE IF ( @MONTH = 'Aug' )
BEGIN
 SET @MYSQLMONTH = '08';
END
ELSE IF ( @MONTH = 'Sep' )
BEGIN
 SET @MYSQLMONTH = '09';
END
ELSE IF ( @MONTH = 'Oct' )
BEGIN
 SET @MYSQLMONTH = '10';
END
ELSE IF ( @MONTH = 'Nov' )
BEGIN
 SET @MYSQLMONTH = '11';
END
ELSE
BEGIN
 SET @MYSQLMONTH = '12';
END

DECLARE @CurrentMySQLDate VARCHAR(100);
SET @CurrentMySQLDate = @MYSQLYEAR+'-'+@MYSQLMONTH+'-'+@MYSQLDAY + ' 00:00:00.000';

INSERT INTO micro_data.dbo.ReadRecords(Terminal_ID, Badge_ID, Rec_Date, Rec_Time, Type_InOut)
 SELECT Terminal_ID, Badge_ID, Rec_Date, Rec_Time, Type_InOut FROM micro_data.clockin.attend
 UNION
 SELECT Terminal_ID, Badge_ID, Rec_Date, Rec_Time, Type_InOut FROM micro_data.dbo.ReadRecords; 
GO