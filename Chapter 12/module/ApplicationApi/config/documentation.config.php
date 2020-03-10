<?php
return array(
    'ApplicationApi\\V1\\Rpc\\Encryption\\Controller' => array(
        'GET' => array(
            'response' => '{
                "output": "[hash]"
            }',
            'description' => 'String conversion',
        ),
        'description' => 'Service for converting text into hash',
        'POST' => array(
            'request' => '{
                "input": "Text to encrypt."
             }',
                         'response' => '{
                "Original text": "Encrypted text."
             }',
            'description' => 'Converts passed text into sha1 hash format.',
        ),
    ),
    'ApplicationApi\\V1\\Rest\\Comics\\Controller' => array(
        'description' => 'Comics Management.',
        'collection' => array(
            'description' => 'Manage multiple records.',
            'GET' => array(
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics"
       },
       "first": {
           "href": "/comics?page={page}"
       },
       "prev": {
           "href": "/comics?page={page}"
       },
       "next": {
           "href": "/comics?page={page}"
       },
       "last": {
           "href": "/comics?page={page}"
       }
   }
   "_embedded": {
       "comics": [
           {
               "_links": {
                   "self": {
                       "href": "/comics[/:comics_id]"
                   }
               }
              "title": "Comics title.",
              "thumb": "Comics thumbnail",
              "id": "Comics id."
           }
       ]
   }
}',
                'description' => 'Returns a list of comics, limited to 2.',
            ),
            'POST' => array(
                'description' => 'Creates many comics from the passed list.',
                'request' => '{
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics[/:comics_id]"
       }
   }
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
            ),
            'PATCH' => array(
                'description' => 'Updates single data from the passed comics list.',
                'request' => '{
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics"
       },
       "first": {
           "href": "/comics?page={page}"
       },
       "prev": {
           "href": "/comics?page={page}"
       },
       "next": {
           "href": "/comics?page={page}"
       },
       "last": {
           "href": "/comics?page={page}"
       }
   }
   "_embedded": {
       "comics": [
           {
               "_links": {
                   "self": {
                       "href": "/comics[/:comics_id]"
                   }
               }
              "title": "Comics title.",
              "thumb": "Comics thumbnail",
              "id": "Comics id."
           }
       ]
   }
}',
            ),
            'PUT' => array(
                'description' => 'Updates all data from the passed comics list.',
                'request' => '{
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics"
       },
       "first": {
           "href": "/comics?page={page}"
       },
       "prev": {
           "href": "/comics?page={page}"
       },
       "next": {
           "href": "/comics?page={page}"
       },
       "last": {
           "href": "/comics?page={page}"
       }
   }
   "_embedded": {
       "comics": [
           {
               "_links": {
                   "self": {
                       "href": "/comics[/:comics_id]"
                   }
               }
              "title": "Comics title.",
              "thumb": "Comics thumbnail",
              "id": "Comics id."
           }
       ]
   }
}',
            ),
        ),
        'entity' => array(
            'description' => 'Single record management.',
            'GET' => array(
                'description' => 'Gets a comics by ID.',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics[/:comics_id]"
       }
   }
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
            ),
            'PATCH' => array(
                'description' => 'Updates single data for comics.',
                'request' => '{
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics[/:comics_id]"
       }
   }
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
            ),
            'PUT' => array(
                'description' => 'Updates all data for comics.',
                'request' => '{
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics[/:comics_id]"
       }
   }
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
            ),
            'DELETE' => array(
                'description' => 'Deletes given comics.',
                'request' => '{
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
                'response' => '{
   "_links": {
       "self": {
           "href": "/comics[/:comics_id]"
       }
   }
   "title": "Comics title.",
   "thumb": "Comics thumbnail",
   "id": "Comics id."
}',
            ),
        ),
    ),
);
