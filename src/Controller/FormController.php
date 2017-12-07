<?php

namespace App\Controller;

use App\Command\FetchMarketpriceCommand;
use App\Form\FetchMarketType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

class FormController extends Controller
{
    /**
     * @Route("/", name="form")
     *
     * @param KernelInterface $kernel
     * @param FetchMarketpriceCommand $command
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function index(KernelInterface $kernel, FetchMarketpriceCommand $command, Request $request): Response
    {
        $content = '';
        $form = $this->createForm(FetchMarketType::class);
        $form->add('submit', SubmitType::class, [
            'label' => 'Send',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $request->request->get($form->getName());
            $definitions = $command->getDefinition();

            $input['command'] = $command::$defaultName;
            foreach ($definitions->getArguments() as $argument) {
                $name = $argument->getName();
                $input[$name] = $data[$name];
            }

            foreach ($definitions->getOptions() as $option) {
                $name = $option->getName();
                if (!empty($data[$name])) {
                    $input['--' . $name] = $data[$name];
                }
            }

            $app = new Application($kernel);
            $app->setAutoExit(false);
            $output = new BufferedOutput();
            $app->run(new ArrayInput($input), $output);
            $content = $output->fetch();
        }

        return $this->render('Form/index.html.twig', [
            'form' => $form->createView(),
            'content' => $content,
        ]);
    }
}
