# Apple-Product-Availability
A docker container which continuously checks Apple Store inventory and emails when found

[![](https://images.microbadger.com/badges/image/icheko/apple-product-availability.svg)](http://microbadger.com/images/icheko/apple-product-availability "Get your own image badge on microbadger.com")
[![](https://images.microbadger.com/badges/version/icheko/apple-product-availability.svg)](http://microbadger.com/images/icheko/apple-product-availability "Get your own version badge on microbadger.com")

# Terminal Awesomeness
```
Every 30s: php index.php                                    2016-09-18 04:43:44

Monitoring availability for the following:

Product [0] Apple Watch Series 2, 42mm Space Gray Aluminum Case with Black Sport Band
Product [1] Apple Watch Series 2, 42mm Silver Aluminum Case with White Sport Band

          STORE/PRODUCT DESCRIPTION           | PROD. NUM |     AVAILABILITY     |

Store: Sherman Oaks
    Apple Watch Series 2, 42mm Space Gray A..       0           unavailable
    Apple Watch Series 2, 42mm Silver Alumi..       1           unavailable

Store: Northridge
    Apple Watch Series 2, 42mm Space Gray A..       0           unavailable
    Apple Watch Series 2, 42mm Silver Alumi..       1           unavailable
.
.
.

Store: Pasadena
    Apple Watch Series 2, 42mm Space Gray A..       0           unavailable
    Apple Watch Series 2, 42mm Silver Alumi..       1           unavailable

Store: Simi Valley
    Apple Watch Series 2, 42mm Space Gray A..       0           unavailable
    Apple Watch Series 2, 42mm Silver Alumi..       1           unavailable


Nothing found. Sad face :'(
```
# Sample Email
![Image of Yaktocat](https://raw.githubusercontent.com/icheko/apple-product-availability/master/email_example.jpg)

Note: Most likely this will go to spam. Make sure to setup a filter for the subject "Apple Product Availability Update" and check the box `Never send it to Spam`.

Gmail: https://support.google.com/mail/answer/6579?hl=en

# Run it
```
docker run \
	-it \
	--rm \
	-e APP_ZIP_CODE=91405 \
	-e APP_PRODUCTS="MP062LL/A,MNPJ2LL/A" \
	-e APP_NOTIFY_EMAIL="your@email.com" \
	icheko/apple-product-availability
```

Docker for Mac: https://docs.docker.com/engine/installation/mac

Docker for Windows: https://docs.docker.com/engine/installation/windows

# Kill it
`control + c`

# Hat Tip
https://gist.github.com/jeremygibbs/1d62544ee57dc4ee8633
