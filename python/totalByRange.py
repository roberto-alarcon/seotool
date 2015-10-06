# import libraries 
from bs4 import BeautifulSoup
import re
import urllib2
import os
from datetime import date, timedelta

# include functions
import myfunctions

# Creamos documento
absolutePath        = 'cine'

# -- General
file_general        = './espectaculos2014/'+absolutePath+'-total.csv'
myfunctions.createCSV(file_general,'URL ;Fecha de Publicacion\n')

diaMaximo = '2013-03-01'
cont = 0



while (cont < 1000):
    cont = cont + 1
    miDia = cont
    d=date.today()-timedelta(days=cont)
    print d
    
    if (str(d) == diaMaximo ):
        break
    else:

        URLGSA = "http://googleak.esmas.com/search?q=site:http://www2.esmas.com/entretenimiento/"+absolutePath+"&btnG=Google+Search&access=p&client=pgeneral&output=xml_no_dtd&proxystylesheet=sitemap_td&oe=UTF-8&ie=UTF-8&ud=1&exclude_apps=1&site=default_collection&entqr=1&entqrm=0&sort=date%3AD%3AS%3Ad1&getfields=*&num=100&requiredfields=pubDate:"+str(d)
        #print URLGSA 
        array_nodos = []
        # -- Read sitemap from url
        print 'Reading sitemap....'
        page = urllib2.urlopen(URLGSA).read()
        #print page
        
        soup = BeautifulSoup(page)
        AllNodesGSA = soup.findAll('url')
        
        for node in AllNodesGSA:
            
            #print str(node.loc).replace('<loc>',"").replace('</loc>',"")
            #print str(node.lastmod).replace('<lastmod>',"").replace('</lastmod>',"")
            
            array_nodos.append(node.loc)
            

        print str(len(array_nodos)) + ' - ' +  str(d)
        
        file=open(file_general,'a')
        
        file.write( str(d) +';')
        file.write( str(len(array_nodos)) +'\n')
        file.close()

#rint AllNodesGSA
print '************ Listo ******************'