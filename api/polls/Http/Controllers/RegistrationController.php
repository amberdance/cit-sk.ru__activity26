<?php
namespace RegionalPolls\Http\Controllers;

final class RegistrationController extends Controller
{

    /**
     * @var \RegionalPolls\Models\Registration
     */
    protected $model;

    public function registration()
    {

        $this->HttpMethod('POST');

        $phoneNumber = formatPhoneNumber($this->request->params['phone']);

        if ($this->model->isPhoneNumberRegistered($phoneNumber)) {
            return $this->error(30, 'Phone number was registered before');
        }

        $verifyCode = rand(1000, 9999);
        $token      = createtoken();

        $userId = $this->model->registerUser([
            'token'      => $token,
            'name'       => $this->request->params['name'],
            'surname'    => $this->request->params['surname'],
            'patronymic' => $this->request->params['patronymic'],
            'phone'      => $phoneNumber,
        ]);

        $params = [
            'user_id'     => $userId,
            'verify_code' => $verifyCode,
            'type'        => 'call',
            'response'    => $this->model->makeIncomeCall($phoneNumber, $verifyCode),
        ];

        $this->model->addVerifyCode($params);

        return $this->json([
            'token' => $token,
        ]);
    }

    public function verifyCode()
    {
        $this->HttpMethod('GET');

        $userId              = $this->model->getUserIdBytoken($this->request->params['token']);
        $isVerifyCodeExpired = $this->model->isVerifyCodeExpired($userId);

        if ($isVerifyCodeExpired) {
            return $this->error(40, 'Verify code was exhausted');
        }

        $isVerifyCodeMatched = $this->model->isVerifyCodeMatched($userId, (int) $this->request->params['code']);

        if ($isVerifyCodeMatched) {
            return $this->success();
        } else {
            $this->model->increaseAttempts($userId);

            return $this->error(50, 'Code is wrong');
        }
    }

    public function resetCode()
    {
        $this->HttpMethod('GET');

        // $verifyCode = rand(1000, 9999);
        // $token      = $this->request->params['token'];

        // $params = [
        //     'user_id'     => $this->model->getUserIdByToken($token),
        //     'verify_code' => $verifyCode,
        //     'type'        => 'call',
        //     'response'    => $this->model->makeIncomeCall($this->model->getPhoneNumberByToken($token), $verifyCode),
        // ];

        // $this->model->addVerifyCode($params);

        return $this->success();

    }
}
