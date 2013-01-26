#!/usr/bin/env python
"""
Read HTML from stdin and pretty print it to stdout, stripping comments.
IT IS SO PRETTY.
"""
import re
import sys
import bs4
if __name__ == "__main__":
    soup = bs4.BeautifulSoup(sys.stdin.read(), "html5lib")
    comments = soup.findAll(text=lambda text:isinstance(text, bs4.Comment))
    [comment.extract() for comment in comments]
    output = soup.prettify(formatter = 'html')
    # Fix link output (don't add extra spaces at the end of link tags!)
    output = re.sub(r'([a-zA-Z0-9])(\s+)\<\/a\>\s*(\.)?', r'\1</a>\3', output)
    sys.stdout.write(output)
