<?php
namespace Cant\Phase\Me\Presenters;

use Rhubarb\Leaf\Presenters\HtmlPresenter;

class Keybase extends HtmlPresenter
{
    protected function createView()
    {
        parent::createView();

        print <<<TXT
==================================================================
https://keybase.io/cute
--------------------------------------------------------------------

I hereby claim:

  * I am an admin of http://cantphase.me
  * I am cute (https://keybase.io/cute) on keybase.
  * I have a public key with fingerprint 60A5 463C C97C AE36 BBDB  FBAC 5D88 7CCA 6F8F DEFA

To do so, I am signing this object:

{
    "body": {
        "key": {
            "fingerprint": "60a5463cc97cae36bbdbfbac5d887cca6f8fdefa",
            "host": "keybase.io",
            "key_id": "5d887cca6f8fdefa",
            "kid": "010123e9e1a05282c7d7fb3e601c987a8346fd6c2fc3bc1c33c17444b5aae191af6e0a",
            "uid": "17550e2bb9ff2c26dcce8ed178e32619",
            "username": "cute"
        },
        "service": {
            "hostname": "cantphase.me",
            "protocol": "http:"
        },
        "type": "web_service_binding",
        "version": 1
    },
    "ctime": 1435915936,
    "expire_in": 157680000,
    "prev": "404d50d1298cc2ce80663b71ddf6e685ada39cf79dea6b43fd17746eebc4e615",
    "seqno": 3,
    "tag": "signature"
}

which yields the signature:

-----BEGIN PGP MESSAGE-----
Version: Keybase OpenPGP v2.0.20
Comment: https://keybase.io/crypto

yMISAnicbZJdSBRRFMd3NSulwig0FNOGgopV5s7HnZlNi6RUEkW0gkha7tfooO2O
s7OaSSk9SQ9Bn/hgodiHfbxEEZZRGoZUKIgZRPhiYvlgIaXpQ9kdybfuy+Wc8z//
c3+XM7A+3pfkz8/JeFme8U30v+vPjfmOXDva0STgCG0Ugk1CDVu+TCtcxRzbscKu
EBSgiFQFyoQYGkFMhhhTbGJEVKrrGiEImrpJmYmEgFAdiXod3AajKMuxIjzHg5BF
efY/+prlgghEIMnMYACJqqRLRKOaiWUGRUAMXUO6rECTQiKZRMYEEFkmQFMUBasI
MWAAZEImenaxZTugqarIJIwN05SIBCkhTGcUaDqTJQgMTxhlThidZFxNYi4TzgQE
nqm3CPPwPYqVKgq7drXHwsOAYDsRN0IitbxS7bp20Gt0G21P2cBw6J9HCFthyr+Q
N9QzJ2pFwkIQcCVxLc8UKLJqANWQYUBgp2zLYSHLU6ga1EV+vDGsnlsqokJVkQLJ
0AmROIQIoYw1QCkHhrqKKJINYmoGZQhiRTY5o6ZAxjBRGASq4FHVhSNCUObPRFXc
MmpVhZEbczjyq77KVT5/km91Qpy3BL6kxOSV1fi8tOZPtpkcL+Vt0FOaWiqm/aV9
qfbB732/7Pay+J2B4al3Bl3sn1m3WH5zcO+WvATx0a0S/2h+5dgl2875dLHltxSf
mPHl+lK2T4m73/P4GKo8rmwfHfKzhuYPSpo7mFBctL91oKf1Xvnzos4bd8eHTxg7
Qt3t6XGN9Q67vXbJn7DxY+3gnH4g58qTn+dj/sLZc83ds7llD3Z3l47uiY7g8tPj
eu/Drp4KZ6Kqrm3TRPLW4sa219ktWScWj+1Kryx4O9k1/WYhNWNq4UeB1Gsd3Ey/
OlfHTr5P6X36bHhocg5kHu6fT3Mvz850F4xsyzrbkfi2a35fyUB+5yFSeCfzwovU
v5CWJLE=
=DvK+
-----END PGP MESSAGE-----

And finally, I am proving ownership of this host by posting or
appending to this document.

View my publicly-auditable identity here: https://keybase.io/cute

==================================================================
TXT;

    }

}