<!doctype html>
<html lang="pt-br">
  <head>
		{:Head:}
  </head>
  <body>
   {TopBar}
    <div class="wrapper">
      <div class="body-container">
      <div class="default-container">
        <div class="user-profile-left-area">
          <div class="header">
            <div class="linus-profile-img" style="background-image: url('{p_UserAvatar}')" alt="{p_UserName}"></div>
            <div class="linus-profile-byuser-data">
              <div class="display-name">
                {p_UserProfileName}
              </div>
              <div class="system-name">
                {p_UserName}
              </div>
              <div class="display-motto">
                {p_UserMotto}
              </div>
              <div class="team-and-role">
                
              </div>
              <div class="display-location">
                {p_UserLocation}
              </div>
              <div class="display-href">
                <a href="{p_UserUrl}" target="_blank">{p_UserUrl}</a>
              </div>
            </div>
          </div>
          <div class="feed">

            <p class="title">Updates</p>
            <div class="comment-list"></div>
            
                 <div class="thereisnofeed">
                  Nenhuma atividade ainda. :/
                </div>
          </div>
        </div>
        <div class="user-profile-right-area">
          <div class="status">
            <p class="title">Status</p>
            <div class="linus-profile-bysystem-data">
              <div class="connection-status offline">
                Offline
              </div>
              <div class="last-online">
                Última vez online: há 18 dias
              </div>
            </div>
            <div class="linus-profile-activity">
              <p class="activity">
                <span class="icon"><i class="fa fa-gamepad"></i></span>
                <span class="data"><b>0</b> Jogos</span>
              </p>

              <!-- <p class="activity">
                <span class="icon"><i class="fa fa-picture-o"></i></span>
                <span class="data"><b>0</b> Screenshots</span>
              </p>
              <p class="activity">
                <span class="icon"><i class="fa fa-video-camera"></i> </span>
                <span class="data"><b>0</b> Vídeos</span>
              </p> -->
              <p class="activity">
                <span class="icon"><i class="fa fa-pencil-square"></i> </span>
                <span class="data"><b>0</b> Análises</span>
              </p>
              <p class="activity">
                <span class="icon"><i class="fa fa-comment"></i> </span>
                <span class="data"><b>0</b> Comentários</span>
              </p>
              <!--
                  <p class="activity community">
                    <span class="icon"><i class="fa fa-comments"></i></span>
                    <span class="data">12 Posts no fórum</span>
                  </p>
                  <p class="activity publisher">
                    <span class="icon"><i class="fa fa-bullhorn"></i></span>
                    <span class="data">1 Game publicado</span>                 </p>
                  -->
            </div>
          </div>


          <div class="friends">
            <p class="title" data-js="modal-trigger" data-modal-name="Amigos de {p_UserProfileName} ({p_friendCount}})" data-modal-url="./get.php?friends">Amigos (30)</p>
            <div class="linus-profile-friends-list">
              <div class="friend" onclick="javascript:le.goToProfile('LordTorrens');">
                <div class="avatar" style="background-image: url('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/t1.0-1/c0.0.160.160/p160x160/558033_538591252892065_681898482_n.jpg');"></div>
                <div class="data">
                  <div class="name">
                    LordTorrens
                  </div>
                  <div class="status online">
                    Online
                  </div>
                </div>
              </div>
              <div class="friend" onclick="javascript:le.goToProfile('LordTorrens');">
                <div class="avatar" style="background-image: url('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xpf1/t1.0-1/c0.0.160.160/p160x160/1185436_503174056438980_141775774_n.jpg');"></div>
                <div class="data">
                  <div class="name">
                    ManoLeo
                  </div>
                  <div class="status offline">
                    Último acesso: há 15 minutos
                  </div>
                </div>
              </div>

              <div class="friend" onclick="javascript:le.goToProfile('LordTorrens');">
                <div class="avatar" style="background-image: url('https://fbcdn-sphotos-a-a.akamaihd.net/hphotos-ak-xpa1/t1.0-9/10373989_538677176242212_121047876881368003_n.jpg');"></div>
                <div class="data">
                  <div class="name">
                    MrHUE
                  </div>
                  <div class="status online">
                    Online
                  </div>
                </div>
              </div>
              <div class="friend" onclick="javascript:le.goToProfile('LordTorrens');">
                <div class="avatar" style="background-image: url('https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xfa1/t1.0-1/p160x160/10372311_882953205063999_1192384670590234365_n.jpg');"></div>
                <div class="data">
                  <div class="name">
                    MermaidFromWeb
                  </div>
                  <div class="status online">
                    Online
                  </div>
                </div>
              </div>
              <div class="friend" onclick="javascript:le.goToProfile('LordTorrens');">
                <div class="avatar" style="background-image: url('https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-xfp1/t1.0-9/1391436_3613525273940_1678843341_n.jpg');"></div>
                <div class="data">
                  <div class="name">
                    KingTesker
                  </div>
                  <div class="status offline">
                    Último acesso: há 2 semanas
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
{:Footer:}
    </div>
    <script src="[static]/scripts/linkr.store.userprofile.js"></script>
  <script>
    var iniReviewData = {
      "reviews.total": 15,
      "reviews": [{
        "id": 797,
        "info": {
          "type": "down",
          "date": 1291555489,
          "stars": 65,
          "comments": 47
        },
        "content": "Suspendisse dapibus blandit leo a cursus. Integer rhoncus metus nec magna tempor rhoncus. Pellentesque ac nunc vel nunc sodales sagittis. Suspendisse dapibus blandit leo a cursus. Integer rhoncus metus nec magna tempor rhoncus. Pellentesque ac nunc vel nunc sodales sagittis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu tortor fermentum, commodo lacus nec, fermentum risus. Quisque sagittis volutpat velit, non hendrerit enim egestas nec. ",
        "author": {
          "sname": "william",
          "name": "William",
          "avatar": "http:\/\/api.randomuser.me\/portraits\/men\/97.jpg",
          "rank": "member",
          "activity": {
            "games": 31,
            "reviews": 31,
            "posts": 1,
            "published": 7
          }
        },
        "fav": 1
      }, {
        "id": 798,
        "info": {
          "type": "up",
          "date": 1185673841,
          "stars": 55,
          "comments": 30
        },
        "content": "Ela \u00e9 jovem, bonita, tem forma\u00e7\u00e3o universit\u00e1ria e \u00e9 engenheira de computa\u00e7\u00e3o. Before this moment millions of applications will need to either adopt a new convention for time stamps or be migrated to 64-bit systems which will buy the time stamp a \"bit\" more time. Before this moment millions of applications will need to either adopt a new convention for time stamps or be migrated to 64-bit systems which will buy the time stamp a \"bit\" more time. ",
        "author": {
          "sname": "donna",
          "name": "Donna",
          "avatar": "http:\/\/api.randomuser.me\/portraits\/women\/68.jpg",
          "rank": "gamer",
          "activity": {
            "games": 0,
            "reviews": 37,
            "posts": 16,
            "published": 2
          }
        },
        "fav": 1
      }, {
        "id": 799,
        "info": {
          "type": "down",
          "date": 1237535162,
          "stars": 85,
          "comments": 42
        },
        "content": "The unix time stamp is a way to track time as a running total of seconds. The unix time stamp is a way to track time as a running total of seconds. Ela \u00e9 jovem, bonita, tem forma\u00e7\u00e3o universit\u00e1ria e \u00e9 engenheira de computa\u00e7\u00e3o. Suspendisse dapibus blandit leo a cursus. Integer rhoncus metus nec magna tempor rhoncus. Pellentesque ac nunc vel nunc sodales sagittis. ",
        "author": {
          "sname": "elizabeth",
          "name": "Elizabeth",
          "avatar": "http:\/\/api.randomuser.me\/portraits\/women\/11.jpg",
          "rank": "member",
          "activity": {
            "games": 48,
            "reviews": 36,
            "posts": 26,
            "published": 6
          }
        },
        "fav": 1
      }, {
        "id": 800,
        "info": {
          "type": "down",
          "date": 962721755,
          "stars": 5,
          "comments": 35
        },
        "content": "The unix time stamp is a way to track time as a running total of seconds. The unix time stamp is a way to track time as a running total of seconds. The unix time stamp is a way to track time as a running total of seconds. Date instances refer to a specific point in time. Calling toString will return the date formatted in a human readable form in American English. ",
        "author": {
          "sname": "carol",
          "name": "Carol",
          "avatar": "http:\/\/api.randomuser.me\/portraits\/women\/42.jpg",
          "rank": "gamer",
          "activity": {
            "games": 22,
            "reviews": 37,
            "posts": 12,
            "published": 4
          }
        },
        "fav": 1
      }, {
        "id": 801,
        "info": {
          "type": "up",
          "date": 953021254,
          "stars": 60,
          "comments": 26
        },
        "content": "Date instances refer to a specific point in time. Calling toString will return the date formatted in a human readable form in American English. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris eu tortor fermentum, commodo lacus nec, fermentum risus. Quisque sagittis volutpat velit, non hendrerit enim egestas nec. Before this moment millions of applications will need to either adopt a new convention for time stamps or be migrated to 64-bit systems which will buy the time stamp a \"bit\" more time. ",
        "author": {
          "sname": "michael",
          "name": "Michael",
          "avatar": "http:\/\/api.randomuser.me\/portraits\/women\/78.jpg",
          "rank": "dev",
          "activity": {
            "games": 29,
            "reviews": 25,
            "posts": 15,
            "published": 1
          }
        },
        "fav": 0
      }]
    };
    le.userProfile.init();
  </script>
  </body>
</html>