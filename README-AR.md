<div dir="rtl">
            <p>السلام عليكم ورحمة الله وبركاته</p>

<p><a href="https://github.com/ahmedsaoud31/payfort-php" rel="nofollow" target="_blank">https://github.com/ahmedsaoud31/payfort-php</a></p>

<ul>
<li><p>المكتبة [1] كُتبت ضمن مشروع خاص عملت عليه، فقمت بتعديلها لتصلح للاستخدام العام وطرحها لمن أراد استخدام البوابة في عمليات الدفع الإلكترونية.</p></li>
<li><p>المكتبة خاصة ببوابة الدفع [2] Payfort وهي بوابة لحلول الدفع الإلكترونية في الشرق الأوسط وتدعم بعض الدول العربية منها (السعودية ومصر والأردن وعمان ولبنان والإمارات المُتحدة).</p></li>
</ul>

<p>المكتبة خاصة للغة PHP وتتعامل مع الـ API الخاص بالبوابة عبر [3] Merchant Page 2.0</p>

<p>يُمكنك تهيئة المكتبة عبر composer أو بتضمين الملف بشكل مباشر، ويُمكنك استخدامها مع أطر عمل مثل Laravel  والعمل بشكل مباشر عبر تضمينها من خلال composer أو بشكل مباشر .</p>

<p>لتهيئة المكتبة من خلال composer نفذ الأمر التالي من شاشة الأوامر/الطرفية وأنت داخل مجلد المشروع:</p>

<pre dir="ltr"><code>composer require ahmedsaoud31/payfort-php dev-master
</code></pre>

<p>أو من خلال تعديل ملف composer.json</p>

<pre dir="ltr"><code>{
    "require": {
        "ahmedsaoud31/payfort-php": "dev-master"
    }
}
</code></pre>

<p>ثم نفذ الأمر التالي عبر شاشة الأوامر/الطرفية:</p>

<pre dir="ltr"><code>composer update
</code></pre>

<p>لاستخدام المكتبة قم بتضمين ملف التحميل التلقائي للفئات autoload.php كالتالي:</p>

<pre dir="ltr"><code>&lt;?php
require 'vendor/autoload.php';

use Payfort\Payfort;

$payfort = new Payfort;
</code></pre>

<p>ولتضمين المكتبة بشكل مباشر استخدم:</p>

<pre dir="ltr"><code>&lt;?php
require 'path/to/Payfort.php';

use Payfort\Payfort;

$payfort = new Payfort;
</code></pre>

<p>لضبط الإعدادات الخاصة بالبوابة قم بالتعديل على الملف <code>path/to/config.php</code> لضبط كافة الإعدادات الخاصة بالبيئة الإختبارية Sandbox والبيئة الفعلية Live.</p>

<p>لإجراء عملية دفع عبر البوابة يجب عليك تفعيل TLS v1.2 ومكتبة CURL وضبط شهادة الموقع https (من غير الضروري توقيع الشهادة في البيئة التجريبية)</p>

<p>أولاً: عليك تكوين نموذج بالبيانات (اسم صاحب البطاقة ورقم البطاقة وتاريخ الإنتهاء والرقم التأكيدي)</p>

<pre dir="ltr"><code>&lt;form role="form" id="gatawayForm" method="POST" action="#"&gt;
    &lt;input type="hidden" name="card_holder_name" value=""&gt;
    &lt;input type="hidden" name="card_number" value=""&gt;
    &lt;input type="hidden" name="card_security_code" value=""&gt;
    &lt;input type="hidden" name="expiry_date" value=""&gt;
&lt;/form&gt;
</code></pre>

<ul>
<li><p>قبل إرسال النموذج إلى بوابة الدفع عليك إرسال طلب للخادوم الخاص بك واستلام البيانات المُعادة من الدالة getFormData وتضمينها في النموذج في الأعلى باستخدام لغة javaScipt وضبط الـ action للنموذج من القيمة host المُعادة من نفس الدالة.</p></li>
<li><p>ملف استدعاء دالة getFormData  على الخادوم يكون على النحو التالي:</p>

<pre dir="ltr"><code>$payfort = new Payfort;
$result = $payfort-&gt;setMerchantReference('ABc123')
                -&gt;setLanguage('en')
                -&gt;getFormData();
</code></pre></li>
<li><p>وداخل ملف معالجة الطلب المُعاد من البوابة والذي يتم ضبطه في الإعدادات return_url سيكون شفرة الدفع كالتالي:</p>

<pre dir="ltr"><code>$result = $payfort-&gt;setCardHolderName('Ahmed')
                    -&gt;setCustomerEmail('ahmedsaoud31@gmail.com')                            -&gt;setCurrency('USD')
                    -&gt;setAmount(100)
                    -&gt;pay();

if(!isset($payfort-&gt;response)){
    echo 'Call payment gataway error!';
}

if(isset($payfort-&gt;response-&gt;{'3ds_url'})){
    header('Location: '.$payfort-&gt;response-&gt;{'3ds_url'});
}

if($result-&gt;pay){
    echo 'Success';
}else{
    echo 'Failed';
}
</code></pre></li>
<li><p>للتحويل من البيئة التجريبية إلى البيئة الفعلية أثناء وقت التشغيل يُمكنك التبديل من خلال الدالة setLive التي تأخذ قيمة منطقية true للتبديل إلى بيئة الفعلية وfalse للتبديل إلى البيئة التجريبية (سيتم تجاهل القيم التي تم ضبطها في ملف الإعدادات عند استخدام تلك الدالة للكائن الحالي المطبقة عليه)</p>

<pre dir="ltr"><code>$payfort-&gt;setLive(false)
        -&gt;...
</code></pre></li>
<li><p>ضبط بعض ال`عدادت أثناء وقت التشغيل: </p>

<pre dir="ltr"><code>$payfort-&gt;setLive($data)
        -&gt;setCommand($data)
        -&gt;setServiceCommand($data)
        -&gt;setMerchantReference($data)
        -&gt;setLanguage($data)
        -&gt;setRememberMe($data)
        -&gt;setExpiryDate($data)
        -&gt;setCardNumber($data)
        -&gt;setCardSecurityCode($data)
        -&gt;setReturnUrl($data)
        -&gt;setCustomerIP($data)
        -&gt;setCardHolderName($data)
        -&gt;setCustomerEmail($data)
        -&gt;setCurrency($data)
        -&gt;setAmount($data)
        -&gt;pay();
</code></pre></li>
</ul>

<p>[1] <a href="https://github.com/ahmedsaoud31/payfort-php" rel="nofollow" target="_blank">https://github.com/ahmedsaoud31/payfort-php</a></p>

<p>[2] <a href="https://www.payfort.com" rel="nofollow" target="_blank">https://www.payfort.com</a></p>

<p>[3] <a href="https://testfort.payfort.com/api/docs/merchant-page-two/build/index.html" rel="nofollow" target="_blank">https://testfort.payfort.com/api/docs/merchant-page-two/build/index.html</a></p>

<p>[4] <a href="https://testfort.payfort.com/api" rel="nofollow" target="_blank">https://testfort.payfort.com/api</a></p>

<p><a class="mention" slug="samiremile" user="true" href="/u/samiremile">@SamirEmile</a></p>

        </div>
