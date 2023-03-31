# AvocadoEdition

아보카도 에디션 코어 파일

-----------------------------

## 설치/실행

### FTP 기반 배포

해당 경로에 있는 파일들을 설치할 Root 디렉토리에 업로드해주세요.  
자세한 설치 방법은 [이곳](https://github.com/tateck-develop/AvocadoEdition/wiki)을 참고해 주시길 바랍니다.

### Docker

> 주로 로컬에서 개발 환경을 구성하실 분들을 위한 부분입니다.  
> 기본적인 [Docker](https://docker.com) 사용법을 안다고 전제하겠습니다.

기본 세팅은 전부 되어 있으므로, 루트로 이동하셔서 compose up을 하시면 됩니다.

```sh
docker-compose up -d
```

기본 세팅은 다음과 같습니다.

* 웹애플리케이션 접속 URL: http://localhost:80
  * 앱 포트 80만 노출했음. DB 포트는 노출 없음
* 최초 설치 시 DB 설정
  * Host: `avocadoedition`
  * User: `avocadoedition`
  * Password: `avocadoedition`

```php
# AvocadoEdition/data/dbconfig.php 샘플
define('G5_MYSQL_HOST', 'db');
define('G5_MYSQL_USER', 'avocadoedition');
define('G5_MYSQL_PASSWORD', 'avocadoedition');
define('G5_MYSQL_DB', 'avocadoedition');
```

기본 세팅을 덮어쓰시려면:

1. `.env.example`이 있는 위치에 `.env` 파일을 만드시고,
2. `.env.example` 내용을 참고하여 `.env`에 필요한 설정을 넣으세요.
   * DB 비밀번호 등을 고치실 때는, 혹시 `AvocadoEdition/data/dbconfig.php` 파일이 이미 만들어져 있을 경우, 이를 삭제해 주세요.
3. `docker-compose up`을 수행하세요.

-----------------------------

2022.04.24 : enter.php 파일 44번 라인 css 연결 경로 수정