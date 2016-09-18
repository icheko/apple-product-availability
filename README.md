# Apple-Product-Availability
A docker container which continuously checks product availability and emails when found

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

# Kill it
`control + c`
