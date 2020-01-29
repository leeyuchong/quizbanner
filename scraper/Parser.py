# Connecting to the database

import urllib.request
from datetime import datetime
from decimal import *
from html.parser import HTMLParser
import ssl
import requests

# importing 'mysql.connector' as mysql for convenient
import mysql.connector as mysql
from bs4 import BeautifulSoup

courseCodes = ("AFRS", "AMCL", "AMST", "ANSO", "ANTH", "AFRS", "ART", "ARTH", "ARTS", "ASIA", "ASL", "ASTR", "BIOC", "BIOL", "BIPS", "CHEM", "CHIN", "CHJA", "CLAN", "CLAS", "CLGR", "CLLA", "CLCS", "CMPU", "COGS", "CREO", "DANC", "DRAM", "ECON", "EDUC", "ENGL", "ENST", "ENVI", "ESCI", "ESSC", "FFS", "FILM", "FREN", "GEAN", "GEOG", "GEOL", "GERM", "GREK", "GRST", "HEBR", "HIND", "HISP", "HIST", "INDP", "INTD", "INTL", "IRSH", "ITAL", "JAPA", "JWST", "ASIA", "LALS", "LAST", "LATI", "MATH", "MEDS", "MRST", "MSDP", "MUSI", "NEUR", "PERS", "PHED", "PHIL", "PHYS", "POLI", "PORT", "PSYC", "PSYC", "RELI", "RUSS", "SOCI", "STS", "SWAH", "SWED", "TURK", "URBS", "VICT", "WMST", "YIDD")

def genScheduleFile():
    headers = {"Referer": "https://aisapps.vassar.edu/cgi-bin/geninfo.cgi",
               "Origin": "https://aisapps.vassar.edu",
               "Content-Type": "application/x-www-form-urlencoded",
               "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
               "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Safari/605.1.15"}

    payload = {"MIME Type": "application/x-www-form-urlencoded",
               "session": "202001",
               "dept": "",
               "instr": "",
               "type": "",
               "day": "",
               "time": "",
               "unit": "",
               "format": "",
               "submit": "Submit"}

    f = requests.post("https://aisapps.vassar.edu/cgi-bin/courses.cgi", data=payload, headers=headers)
    schedule = open('scheduleOfClasses.txt', 'a')
    print(f.text, file=schedule)

class MyHTMLParser(HTMLParser):
    def handle_data(self, data):
        if data.isspace():
            return data
        parsedFile = open('parsedFile.txt', 'a')
        print(data, file=parsedFile)

def parser():
    parser = MyHTMLParser()
    f = open("scheduleOfClasses.txt", "r")
    if f.mode == 'r':
        contents = f.read()
        parser.feed(contents)

class Course:
    inputLn = ""
    values = [None] * 29
    # i=23: starttime1
    # i=24: duration1
    # i=25: starttime2
    # i=26: duration2
    fields = ("id", "courseID", "title", "units", "sp", "max", "enr", "avl", "wl", "gm", "yl", "pr", "fr", "la", "qa",
              "format", "xlist", "d1", "time1", "d2", "time2", "loc", "instructor", "starttime1", "duration1", "delt91"
              "starttime2", "duration2", "delt92")
    fieldPos = [0, 0, 13, 44, 50, 53, 57, 61, 65, 69, 74, 77, 80, 83, 86, 89, 96, 112, 118, 134, 118, 134, 145]

    def __init__(self, inputLine):
        self.inputLn = inputLine

    def scheduleReader(self):
        for i in range (1,29):
            self.values[i] = None
        for i in range(1, 23):
            # if i == 2 or i == 22:
            #    dosomething
            # else:
            if i == 19 or i == 20:
                continue
            elif i < 22:
                self.values[i] = self.inputLn[self.fieldPos[i]:self.fieldPos[i + 1]]
            else:  # if i=22
                self.values[i] = self.inputLn[self.fieldPos[i]:]
            self.values[i] = self.values[i].strip()
            if i == 3 and self.values[i] != "":
                self.values[i] = Decimal(self.values[i])
            if i == 4 or i == 10 or i == 11 or i == 12 or i == 13 or i == 14:
                if self.values[i] != "":
                    self.values[i] = 1
                else:
                    self.values[i] = 0

        if self.values[18] and not('0000' in self.values[18]) and ('AM' in self.values[18] or 'PM' in self.values[18]):
            # starttime1:
            if self.values[18][4:6] == 'AM' or self.values[18][0:2]=='12':
                self.values[23] = int(self.values[18][0:4])
            else:
                self.values[23] = 1200 + int(self.values[18][0:4])

            starttime1 = self.values[23]
            time_starttime1 = datetime(year=2020, month=1, day=1, hour=int(starttime1 / 100),
                                       minute=int(starttime1 % 100), second=0)
            if self.values[18][11:13] == 'AM' or self.values[18][7:9]=='12':
                endtime1 = int(self.values[18][7:11])
            else:
                endtime1 = 1200 + int(self.values[18][7:11])
            time_endtime1 = datetime(year=2020, month=1, day=1, hour=int(endtime1 / 100),
                                     minute=int(endtime1 % 100), second=0)

            self.values[24] = time_endtime1 - time_starttime1
            self.values[24] = int(self.values[24].total_seconds() / 60)

            self.values[25] = time_starttime1 - datetime(year=2020, month=1, day=1, hour=9, minute=0, second=0)
            self.values[25] = float((self.values[25].total_seconds()/60)/60)

        # print(self.values)
        # for i in range(1, 28):
        # print(self.values[i])


# connecting to the database using 'connect()' method
# it takes 3 required parameters 'host', 'user', 'passwd'
db = mysql.connect(
    host="localhost",
    user="root",
    passwd="3476269507",
    database="scheduleOfClasses"
)

# creating an instance of 'cursor' class which is used to execute the 'SQL' statements in 'Python'
cursor = db.cursor()

# creating a databse called 'datacamp'
# 'execute()' method is used to compile a 'SQL' statement
# below statement is used to create tha 'datacamp' database
# cursor.execute("CREATE DATABASE scheduleOfClasses")

# creating a table called 'users' in the 'datacamp' database
'''cursor.execute('CREATE TABLE schedule (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, '
               'CourseID VARCHAR(12), Title VARCHAR(31), Units DECIMAL(2,1), '
               'SP TINYINT, MAX SMALLINT, ENR SMALLINT, AVL SMALLINT, WL TINYINT, GM CHAR(2), '
               'YL TINYINT, PR TINYINT, FR TINYINT, LA TINYINT, QA TINYINT, Format CHAR(3), XLIST VARCHAR(20), '
               'D1 VARCHAR(5), TIME1 VARCHAR(15), D2 VARCHAR(5), TIME2 VARCHAR(15), LOC VARCHAR(10), '
               'INSTRUCTOR VARCHAR(30))')

cursor.execute("DESC schedule")
'''

def updateDesc():
    global courseCodes
    # instantiate the parser and feed it some HTML
    for i in range(1, 25):
        # iterate over page numbers
        urlData = "https://catalog.vassar.edu/content.php?filter%5B27%5D=-1&filter%5B29%5D=&filter%5Bcourse_type%5D" \
                  "=-1&filter%5Bkeyword%5D=&filter%5B32%5D=1&filter%5Bcpage%5D=" + str(i) + "&cur_cat_oid=33&expand=1&navoid=6228&print=1#acalog_template_course_filter"
        # open the url
        webUrl = urllib.request.urlopen(urlData)
        data = webUrl.read().decode("utf-8")
        # create beautiful soup object soup for each webpage
        soup = BeautifulSoup(data, "lxml")
        # trFile to save all the tr blocks in the body
        trFile = open('trFile.txt', 'w+')
        trFileReader = open("trFile.txt", "r")
        for string in soup.body.find_all('tr'):
            # print each tr line to a trFile
            print(repr(str(string)), file=trFile)
        for line in trFileReader:
            # create a new BeautifulSoup object soupTr to extract the text in each line in the trFile
            soupTr = BeautifulSoup(line, "lxml")
            # extract the text
            courseEntry = soupTr.get_text()
            # remove the character sequence \xa0
            courseEntry = courseEntry.replace(r"\xa0", '')
            courseInfo = [None] * 3
            courseCode = courseEntry[21:25].strip()
            if not (courseCode in courseCodes):
                continue
            courseInfo[0] = courseCode
            courseInfo[1] = courseEntry[25:29].strip()
            courseInfo[2] = courseEntry[courseEntry.find("unit(s)") + 7:].replace(r"\n", "").rstrip(r"'").strip()
            courseInfo[2] = courseInfo[2][:-2]
            cursor.execute(
                "UPDATE schedule SET description='%s' WHERE LOCATE('%s',courseID) > 0 AND LOCATE('%s',courseID) > 0" % (
                    courseInfo[2], courseInfo[0], courseInfo[1]))
            db.commit()

def main():
    global cursor
    cursor.execute("DELETE FROM schedule WHERE id>0;")
    cursor.execute("TRUNCATE table schedule;")
    open('parsedFile.txt', 'w+').close()
    open('scheduleOfClasses.txt', 'w+').close()
    genScheduleFile()
    parser()
    rawFile = open("parsedFile.txt", "r")
    for line in rawFile:
        if "Course Listings" in line or "Supplement to the Schedule of Classes" in line or "Course listings for Spring 2020:" in line or "COURSE ID    TITLE                          UNITS" in line or "---------" in line:
            continue
        else:
            course = Course(line)
            course.scheduleReader()
            # print(course.values)
            courseID = course.values[1]
            if courseID != "":
                if courseID[3] == "-" or courseID[4] == '-':
                    query = "INSERT INTO schedule (courseID, title, units, sp, max, enr, avl, wl, gm, yl, pr, fr, la, qa, " \
                            "format, xlist, d1, time1, d2, time2, loc, instructor, starttime1, duration1, delt91, starttime2, " \
                            "duration2, delt92) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, " \
                            "%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
                    values = course.values[1:29]
                    # print(course.values[1:23])
                    cursor.execute(query, values)
                    db.commit()
            else:
                d2Value = course.values[17]
                if "M" in d2Value or "T" in d2Value or "W" in d2Value or "R" in d2Value or "F" in d2Value:
                    t2Value = course.values[18]

                    if "PM" in t2Value or "AM" in t2Value:
                        if "-" in t2Value:
                            # starttime2:
                            if t2Value[4:6] == 'AM' or t2Value[0:2]=='12':
                                starttime2 = int(t2Value[0:4])
                            else:
                                starttime2 = 1200 + int(t2Value[0:4])

                            # duration2:
                            time_starttime2 = datetime(year=2020, month=1, day=1, hour=int(starttime2 / 100),
                                                       minute=int(starttime2 % 100), second=0)
                            if t2Value[11:13] == 'AM' or t2Value[7:9]=='12':
                                endtime2 = int(t2Value[7:11])
                            else:
                                endtime2 = 1200 + int(t2Value[7:11])

                            time_endtime2 = datetime(year=2020, month=1, day=1, hour=int(endtime2 / 100),
                                                       minute=int(endtime2 % 100), second=0)

                            duration2 = time_endtime2 - time_starttime2
                            duration2= int(duration2.total_seconds() / 60)

                            deltnine2 = time_starttime2 - datetime(year=2020, month=1, day=1, hour=9, minute=0, second=0)
                            deltnine2 = float((deltnine2.total_seconds()/60)/60)

                            cursor.execute("SELECT MAX(id) FROM schedule;")
                            maxID = cursor.fetchone()
                            # print(str(maxID))
                            # values = course.values[18:20]
                            # print(str(course.values[18]))
                            cursor.execute("UPDATE schedule SET d2='%s', time2='%s', starttime2='%s', duration2='%s', delt92='%s' WHERE id='%d'" % (
                                course.values[17], course.values[18], starttime2, duration2, deltnine2, maxID[0]))
                            db.commit()
    ssl._create_default_https_context = ssl._create_unverified_context
    updateDesc()

if __name__ == "__main__":
    main()

'''
# defining the Query
query = "SELECT * FROM schedule"

# getting records from the table
cursor.execute(query)

# fetching all records from the 'cursor' object
records = cursor.fetchall()

# Showing the data
for record in records:
    print(record)

# it will print a connection object if everything is fine
# print(db)
'''
