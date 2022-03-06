import mysql.connector
import pyodbc 

# Handle MySQL Connection and data retrival
mysqlConnection = mysql.connector.connect(
  host='192.168.60.32',
  user='dbconnect',
  password='Asd<fA>sdf__123LiTaNN$1)23$',
  database='clockin',
  auth_plugin='mysql_native_password'
)

cursor = mysqlConnection.cursor()
mysqlQueryResult =''

try:
    cursor.execute("SELECT DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal FROM clockin.attend")
    mysqlQueryResult = cursor.fetchall()
    for x in mysqlQueryResult:
      print(x)
except mysql.connector.Error as err:
    print("Error fetching data.")
    print(err)
    exit(1)
finally:
    print("attend done")

mysqlQuerySecondResult =''

try:
    cursor.execute("SELECT DateRecord, TimeRecord, TypeInOut, IdEmp, BadgeNum, ClockNum, ManualRec, EventId, Event_Time, Note, ProjectId, Meal FROM clockin.break")
    mysqlQuerySecondResult = cursor.fetchall()
    for x in mysqlQuerySecondResult:
      print(x)
except mysql.connector.Error as err:
    print("Error fetching data.")
    print(err)
    exit(1)
finally:
    print("break done")
    cursor.close()
    mysqlConnection.close()