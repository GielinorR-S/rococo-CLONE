import os
import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin, urlparse

# URL of the site to scrape images from
SITE_URL = "https://www.rococo.net.au/"
IMG_DIR = "assets/images/"

# Ensure the images directory exists
os.makedirs(IMG_DIR, exist_ok=True)

# Fetch the page
response = requests.get(SITE_URL)
soup = BeautifulSoup(response.text, "html.parser")

# Find all image tags
img_tags = soup.find_all("img")

for img in img_tags:
    img_url = img.get("src")
    if not img_url:
        continue
    # Handle relative URLs
    img_url = urljoin(SITE_URL, img_url)
    # Get image filename
    filename = os.path.basename(urlparse(img_url).path)
    if not filename:
        continue
    # Download image
    try:
        img_data = requests.get(img_url).content
        with open(os.path.join(IMG_DIR, filename), "wb") as f:
            f.write(img_data)
        print(f"Downloaded {filename}")
    except Exception as e:
        print(f"Failed to download {img_url}: {e}")

print("Image download complete.")
