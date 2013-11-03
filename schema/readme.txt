Notice:
Keyword search is use mysql fulltext match
must add fulltext index
ALTER TABLE table ADD FULLTEXT(column1,column2,...)
The deafult match is for at least 4 char words
add this and rebulid the index
[mysqld]
ft_min_word_len=3

Description:
Facebook page is a very useful for business promotion. However, we can not search the pages through Facebook. This application can search the Pages with the exactly name and display them in the Google Map. After one search the result written to database for the further usage.

Search Example: Microsoft, Google, abc, cnn, TD, CIBC and etc
also you can search these pages: livepage, kwcg, bookmato

Facebook API:
FQL is used to query the page table from Facebook.
Also add the Facebook Like Box

About database:
After one search the page information write to the mysql database.
If the location of page is in address, I use Google Maps API to translate it into latitude and longitude.
Then update the page record based on the page_id.
The reason why I add latitude and longitude is that it's convenience to calculate the distance for the further step.

Database name:
livepage
Please run the page.sql.