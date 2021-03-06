## 개요
- 컴파일 서버는 기본적으로 다음을 처리합니다.
  - 웹 서버로부터 전송받은 코드 컴파일 및 저장 ( 완료 )
  - 코드 동등성 검사 및 결과 DB에 저장 ( 테스트 완료 )
  - 문제에 대한 점수 DB에 저장 ( 미완 )

## 기능 구현 (진행 상황)
- Compile Server
  - 서버 셋팅
    - 원격 컴퓨터 이용 - UBUNTU LTS 18.04 (16일 16:00 완료)
  - 데이터 구조
    - 메타 데이터([meta.h](https://github.com/BJ-Lim/hlsw-hackathon/blob/master/Server/src/meta.h))
      ```
      struct meta {
        int request_number; //요청 종류
        char id[10];        //요청자 id
        int subject_id;     //과목 고유 번호
        int assignment_id;  //과제 고유 번호(해당 과목의 과제 일련번호)
      };
      ```
  - 작업 흐름 및 파일명 정의
    1. 대상 코드 수신 / 파일로 저장 : [server_receiver.c](https://github.com/BJ-Lim/hlsw-hackathon/blob/master/Server/src/server_receiver.c) (배포 테스트 완료)
        - 소켓통신 이용
        - 파일 수신 후 fork하여 compile.sh 실행
    2. 대상 코드 컴파일 : [compile.sh](https://github.com/BJ-Lim/hlsw-hackathon/blob/master/Server/src/compile.sh) (배포 테스트 완료)
    3. 결과 파일을 웹 서버로 전송 : [server_sender.c](https://github.com/BJ-Lim/hlsw-hackathon/blob/master/Server/src/server_sender.c) (배포 테스트 완료)
    4. 중복성 검사 폴더로 파일 이동 : [compile.sh]()
    5. 정해진 시간에 중복성 체크 : [미정]()
        - [cron](https://zetawiki.com/wiki/%EB%A6%AC%EB%88%85%EC%8A%A4_%EB%B0%98%EB%B3%B5_%EC%98%88%EC%95%BD%EC%9E%91%EC%97%85_cron,_crond,_crontab) 사용
        
## 프로그램 인자
![screen_shot](https://github.com/BJ-Lim/hlsw-hackathon/blob/master/capture/%ED%94%84%EB%A1%9C%EA%B7%B8%EB%9E%A8%20%EC%9D%B8%EC%9E%90.JPG)
- 현재는 server_sender에 불필요한 매개변수 포함
  
## ISSUE
- 소켓으로 파일을 받은 후 결과를 전송할 때까지 소켓을 block 시킬 것인가?</br>
  ->구현은 간단하나 몹시 비효율적이다.
- 수신 소켓과 송신 소켓을 따로 1개씩 사용할 것인가?</br>
  ->구현은 복잡할 수 있으나 훨씬 효율적이다.</br>
  ->기능상으로 소켓은 파일 전송만을 담당하는 것으로 구성하는 것이 나을 것 같다.</br>
  ->폴더 구조를 어떻게 설계할 것인가?
- 원격 저장소와 지역 저장소 동기화 : [LINK](https://mylko72.gitbooks.io/git/content/remote/remote_sync.html)
- web_sender 소켓이 server_receiver로 meta 데이터를 전송하는 과정에서 데이터가 깨지는 현상 (해결 완료)
  -> send_meta 함수를 호출하지 않음
- web_sender 소켓이 server_receiver로 파일을 전송하는 과정에서 데이터가 깨지는 현상 (해결 완료)
  -> memset을 버퍼 사용전에 먼저 사용했어야 하는데, 사용하지 않음
  
