
#import library
from bs4 import BeautifulSoup
import re
import urllib2
import os , datetime
from datetime import date, timedelta
import mysql.connector
import sys

# Database conection params
config = {
  'user': 'root',
  'password': '',
  'host': '127.0.0.1',
  'database': 'dbSEOTool_develop',
  'raise_on_warnings': True,
}


#Open document
id          = sys.argv[1]
myDomain    = sys.argv[2]
#id  = '27'
#myDomain = 'http:__www2.esmas.com_entretenimiento_musica'
logFilename = "_reqhttp.log"
dirIdReport = "/Applications/XAMPP/htdocs/seo/repository/" + myDomain + "/"+ id +"/"

dirLogFile  =  dirIdReport + logFilename

#Open document and get the range of date
f = open(dirLogFile)
data = f.readline()
print data
f.close()

dateInfo = data.split('@')
print dateInfo[0]
domain      = str(dateInfo[0]).replace("\n","") 
stardate    = str(dateInfo[1]).replace("\n","")  
enddate     = str(dateInfo[2]).replace("\n","") 

# Connect to GSA API and get de xml nodes

#print page

d=date.today()-timedelta(days=2)

print stardate

inDate = True
cont = 0;
while(inDate):
    
    d1 = datetime.datetime.strptime(stardate,"%Y-%m-%d")+timedelta(days=cont)
    request = str(d1).split(' ');
    request_date = request[0]
    print request_date
    
    URLGSA = "http://googleak.esmas.com/search?q=site:"+domain+"&btnG=Google+Search&access=p&client=pgeneral&output=xml_no_dtd&proxystylesheet=sitemap_td&oe=UTF-8&ie=UTF-8&ud=1&exclude_apps=1&site=default_collection&entqr=1&entqrm=0&sort=date%3AD%3AS%3Ad1&getfields=*&num=100&requiredfields=pubDate:"+str(request_date)
    print 'Reading sitemap....'
    page = urllib2.urlopen(URLGSA).read()
    
    #Procees de XML
    soup = BeautifulSoup(page)
    AllNodesGSA = soup.findAll('url')
    
    for node in AllNodesGSA:
        url                 = str(node.loc).replace('<loc>',"").replace('</loc>',"")
        publication_date    = str(node.lastmod).replace('<lastmod>',"").replace('</lastmod>',"")
    
        print url
        
        try:
        
            #Analize de code of the page
            buffer_page = urllib2.urlopen(url).read()
            soupWeb = BeautifulSoup(buffer_page)
            
            # --------------------------------------------------------------------------------
            # Work with Title
            # --------------------------------------------------------------------------------
            total_words         = 0
            title = soupWeb.find('title')
            buffer_page_title = str( title.renderContents() )
            if ( buffer_page_title != '' ):
                total_words = len( buffer_page_title.split(' ')  ) 
                
            # Output title
            print 'Title: ' + buffer_page_title
            print 'Title Words: ' + str(total_words)
            
            # OBTENEMOS EL TITULO POR UNA EXPRESION REGULA
            for mytitle in re.findall('<title>(.*?)</title>',buffer_page):
                print "titulo expresion regular " + mytitle  
                
            # OBTENEMOS EL DESCRIPCION POR UNA EXPRESION REGULA
            for mydescription in re.findall('<title>(.*?)</title>',buffer_page):
                print "titulo expresion regular " + mytitle              
            
            
            # --------------------------------------------------------------------------------
            # Work with Description
            # --------------------------------------------------------------------------------
            total_words_description         = 0
            tag = soupWeb.find(attrs={"name":"Description"})
            print tag
            content = tag['content']
            print content
            
            
            description = soupWeb.findAll(attrs={"name":"Description"})
            print  description['content']
            buffer_page_description = str(description).replace('\n','')
            print buffer_page_description
            
            buffer_page_description          = ""
            print "Load description2"
            for buffer_page_description in re.findall('<meta content=["](.*?)["] name="Description"',description):
                buffer_page_description = buffer_page_description.encode('iso-8859-15').replace(';','')
                #buffer_page_description = buffer_page_description.replace(';','')  
                
            if ( buffer_page_description != '' ):
               total_words_description = len( buffer_page_description.split(' ')  ) 
                   
            # Output Description
            #print 'Description: ' + buffer_page_description
            #print 'Description Words: ' + str(total_words_description)
            print "Load description" 
            
            # --------------------------------------------------------------------------------
            # Work with Keywords
            # --------------------------------------------------------------------------------
            total_words_keywords         = 0
            buffer_page_keywords         = ""
           
            keywords = soupWeb.findAll(attrs={"name":"Keywords"})
            #keywords = str(keywords).replace('\n','').encode('utf-8')
            keywords = str(keywords).replace('\n','')
           
            for buffer_page_keywords in re.findall('<meta content=["](.*?)["] name="Keywords"',keywords):
                buffer_page_keywords = buffer_page_keywords
            
            if ( buffer_page_keywords != '' ):
                total_words_keywords = len( buffer_page_keywords.split(',')  )
        
            
             # Output Description
            print 'Keywords: ' + buffer_page_keywords
            print 'Keywords Words: ' + str(total_words_keywords) 
        
        
            # Works with DB
            publication_date = int(datetime.datetime.strptime(publication_date, '%Y-%m-%d').strftime("%s"))
            
            cnx = mysql.connector.connect(**config)
            cursor = cnx.cursor()
            add_report = ("INSERT INTO Report_content "
                   "(id_Report, URL, title, title_number, description , description_number , keywords , keywords_number , publication_datetime) "
                  "VALUES (%s, %s, %s, %s, %s , %s ,%s, %s, %s)")
            
            data_report = (id, url, str(buffer_page_title),  str(total_words), buffer_page_description , str(total_words_description) , buffer_page_keywords , str(total_words_keywords) , str (publication_date) )
            # Insert new employee
            cursor.execute(add_report, data_report)
            emp_no = cursor.lastrowid
            
            cnx.commit()
            cursor.close()
            cnx.close()
            
            
            
            file = open(dirLogFile,'a')
            file.write('\nCrawling url:'+str(url))
            file.close()
        
        except:
            
            print "Error ->"
            
            cnx = mysql.connector.connect(**config)
            cursor = cnx.cursor()
            add_report = ("INSERT INTO Report_content "
                   "(id_Report, URL, code) "
                  "VALUES (%s, %s, %s)")
            
            data_report = (id, url, '404')
            # Insert new employee
            cursor.execute(add_report, data_report)
            emp_no = cursor.lastrowid
            
            cnx.commit()
            cursor.close()
            cnx.close()
            
    
    cont = cont + 1
    if(request_date == enddate):
        
        # Update Report status to 3 -> ready
        cnx = mysql.connector.connect(**config)
        cursor = cnx.cursor()
        update_report = ("Update Report set status = %s where id_Report = %s;") 
        data_update = ('3', id)
        cursor.execute(update_report, data_update)
        cnx.commit()
        cursor.close()
        cnx.close()   
        
        break


