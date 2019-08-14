<?php

class Pektsekye_Ymm_Adminhtml_YmmController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('ymm/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('ymm/ymm')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('ymm_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('ymm/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('ymm/adminhtml_ymm_edit'))
				->_addLeft($this->getLayout()->createBlock('ymm/adminhtml_ymm_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ymm')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$data ['products_id'] = (int) $data ['products_id'];
			$data ['products_car_make'] = trim(preg_replace('/[^\w\s-]/','',$data ['products_car_make']));
			$data ['products_car_model'] = trim(preg_replace('/[^\w\s-]/','',$data ['products_car_model']));
			$data ['products_car_year_bof'] = (int) $data ['products_car_year_bof'];
			$data ['products_car_year_eof'] = (int) $data ['products_car_year_eof'];

			$model = Mage::getModel('ymm/ymm');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ymm')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ymm')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('ymm/ymm');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $ymmIds = $this->getRequest()->getParam('ymm');
        if(!is_array($ymmIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($ymmIds as $ymmId) {
                    $ymm = Mage::getModel('ymm/ymm')->load($ymmId);
                    $ymm->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($ymmIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $ymmIds = $this->getRequest()->getParam('ymm');
        if(!is_array($ymmIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($ymmIds as $ymmId) {
                    $ymm = Mage::getSingleton('ymm/ymm')
                        ->load($ymmId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($ymmIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
	

    /**
     * Import and export Page
     *
     */
    public function importExportAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('ymm/import')
            ->_addContent($this->getLayout()->createBlock('ymm/adminhtml_ymm_importExport'))
            ->renderLayout();
    }

    /**
     * import action from import/export ymm
     *
     */
    public function importPostAction()
    {
        if ($this->getRequest()->isPost() && !empty($_FILES['import_ymm_file']['tmp_name'])) {
            try {
                $number = $this->_importYmm();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ymm')->__('%d new item(s) were imported',$number));
            }
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ymm')->__('Invalid file upload attempt'));
            }
        }
        else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ymm')->__('Invalid file upload attempt'));
        }
        $this->_redirect('*/*/importExport');
    }

    protected function _importYmm()
    {
        $fileName   = $_FILES['import_ymm_file']['tmp_name'];
        $csvObject  = new Varien_File_Csv();
        $csvData = $csvObject->getData($fileName);
		$number = 0;
        /** checks columns */
        $csvFields  = array(
            0   => Mage::helper('ymm')->__('Products ID'),
            1   => Mage::helper('ymm')->__('Vehicle Make'),
            2   => Mage::helper('ymm')->__('Vehicle Model'),
            3   => Mage::helper('ymm')->__('From Year'),
            4   => Mage::helper('ymm')->__('To Year')
        );

        if ($csvData[0] == $csvFields) {
            foreach ($csvData as $k => $v) {
                if ($k == 0) {
                    continue;
                }

                //end of file has more then one empty lines
                if (count($v) <= 1 && !strlen($v[0])) {
                    continue;
                }

                if (count($csvFields) != count($v)) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ymm')->__('Invalid file upload attempt'));
                }
				
				if (!empty($v[0]) && is_numeric($v[0]) && !empty($v[1])) {
					
				    $v[1] = trim(preg_replace('/[^\w\s-]/','',$v[1]));
					$v[2] = trim(preg_replace('/[^\w\s-]/','',$v[2]));
					
					$resource = Mage::getSingleton('core/resource');
					$read= $resource->getConnection('core_read');
					$ymmTable = $resource->getTableName('ymm');
					$select = $read->select()
											->from($ymmTable,array('id'))
											->where("products_id=?",(int)$v[0])
											->where("products_car_make=?",$v[1])
											->where("products_car_model=?",$v[2])
											->where("products_car_year_bof=?",(int)$v[3])
											->where("products_car_year_eof=?",(int)$v[4])											
											->limit(1);
											
					if($read->fetchOne($select)){
						 continue;
					}	 

					$data  = array(
						'products_id'=>$v[0],
						'products_car_make' => $v[1],
						'products_car_model' => $v[2],
						'products_car_year_bof'  => $v[3],
						'products_car_year_eof'=>$v[4],
					);

					$model  = Mage::getModel('ymm/ymm');
					$model->setData($data);
					$model->save();
					$number++;
                }
            }  
        }
        else {
            Mage::throwException(Mage::helper('tax')->__('Invalid file format upload attempt'));
        }
		
		return $number;
    }

    /**
     * export action from import/export tax
     *
     */
    public function exportPostAction()
    {
        $fileName   = 'ymm.csv';
        $content    = $this->getLayout()->createBlock('ymm/adminhtml_ymm_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }
	
}